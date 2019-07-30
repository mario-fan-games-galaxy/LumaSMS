<?php

define('MODEL_GET', 1);
define('MODEL_PAGINATE', 2);
define('MODEL_COUNT', 3);

class Model {
    public static
        $count,
        $page,
        $pageCount,
        $primaryKey = 'id',
        $table = ''
    ;
    
    protected
        $data,
        $updatedFields = []
    ;
    
    public static function id($id){
        $class = get_called_class();
        
        $row = DB::fetch($sql = "SELECT * FROM " . static::$table . " WHERE " . static::$primaryKey . " = $id");
        
        if(!$row){
            return false;
        }
        
        return static::factory($row);
    }
    
    public static function deleteID($id){
        DB::query("DELETE FROM " . static::$table . " WHERE " . static::$primaryKey . " = $id");
    }
    
    private static function factory($row){
        $class = get_called_class();
        
        $m = new $class();
        $m->sets($row, false);
        $m->load();
        
        return $m;
    }
    
    private static function abstractGet($parts = [], $params = [], $limit = 20, $page = 1, $getType = MODEL_GET){
        if(empty($parts['cols'])){
            $parts['cols'] = '*';
        }
        
        if(empty($parts['where'])){
            $parts['where'] = '';
        }else{
            $parts['where'] = ' WHERE ' . $parts['where'];
        }
        
        if(empty($parts['order'])){
            $parts['order'] = '';
        }else{
            $parts['order'] = ' ORDER BY ' . $parts['order'];
        }
        
        $sql = "SELECT " . $parts['cols'] . " FROM " . static::$table . $parts['where'] . $parts['order'];
        
        switch($getType){
            case MODEL_PAGINATE: {
                static::$count = DB::count($sql, $params);
                static::$pageCount = ceil(static::$count / $limit);
                static::$page = $page;
                
                break;
            }
            
            case MODEL_COUNT: {
                return DB::count($sql, $params);
            }
        }
        
        return DB::query(
            DB::paginate($sql, $limit, $page),
            $params
        );
    }
    
    public static function get($parts = [], $params = [], $limit = 20, $page = 1, $getType = MODEL_GET){
        $query = static::abstractGet($parts, $params, $limit, $page, $getType);
        
        $ret = [];
        
        foreach(DB::fetchAll($query) as $row){
            $ret[] = static::factory($row);
        }
        
        return $ret;
    }
    
    public static function paginate($parts = [], $params = [], $limit = 20, $page = 1){
        return static::get($parts, $params, $limit, $page, MODEL_PAGINATE);
    }
    
    public static function count($parts = [], $params = []){
        return static::abstractGet($parts, $params, false, false, MODEL_COUNT);
    }
    
    public static function first($parts = [], $params = []){
        $query = static::abstractGet($parts, $params, 1, 1, false);
        
        return static::factory(DB::fetch($query));
    }
    
    public function __construct(){
        $this->data = new stdClass();
    }
    
    // gets called when a model is loaded with data
    public function load(){}
    
    public function sets($values, $recordFields = true){
        foreach($values as $key => $value){
            $this->set($key, $value, $recordFields);
        }
        
        return $this;
    }
    
    public function set($key, $value, $recordField = true){
        if($recordField){
            $this->updatedFields[] = $key;
        }
        
        @$this->data->$key = $value;
        
        return $this;
    }
    
    public function f($key){
        if(empty($this->data->$key)){
            return false;
        }
        
        return $this->data->$key;
    }
    
    public function delete(){
        static::deleteID($this->f(static::$primaryKey));
    }
    
    public function save(){
        if($this->f(static::$primaryKey)){
            $sqlFields = [];
            $params = [];
            
            foreach($this->updatedFields as $key){
                $sqlFields[] = "$key = :$key";
                $params[$key] = $this->f($key);
            }
            
            $sql = "UPDATE " . static::$table .
            " SET " . implode(', ', $sqlFields) .
            " WHERE " . static::$primaryKey . " = " . $this->f(static::$primaryKey);
            
            DB::query($sql, $params);
        }else{
            $keys = array_keys($aData = (array)$this->data);
            $pKeys = array_keys($aData);
            
            foreach($pKeys as $key => $value){
                $pKeys[$key] = ':' . $value;
            }
            
            $sql = "INSERT INTO " . static::$table . " ( " . implode(', ', $keys) . " ) " .
            "VALUES ( " . implode(', ', $pKeys) . " )";
            
            DB::query($sql, $aData);
        }
    }
}

?>