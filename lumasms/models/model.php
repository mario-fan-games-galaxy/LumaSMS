<?php

class Model {
    public static
        $primaryKey = 'id',
        $table = ''
    ;
    
    private
        $data,
        $updatedFields = []
    ;
    
    public static function id($id){
        $class = get_called_class();
        
        $row = DB::fetch($sql = "SELECT * FROM " . static::$table . " WHERE " . static::$primaryKey . " = $id");
        
        $m = new $class();
        $m->sets($row, false);
        
        return $m;
    }
    
    public static function deleteID($id){
        DB::query("DELETE FROM " . static::$table . " WHERE " . static::$primaryKey . " = $id");
    }
    
    public static function get($parts = [], $params = [], $limit = 20, $page = 1){
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
        
        $sql = DB::paginate("SELECT " . $parts['cols'] . " FROM " . static::$table . $parts['where'] . $parts['order'], $limit, $page);
        
        $rows = DB::fetchAll($sql);
        
        $class = get_called_class();
        
        $ret = [];
        
        foreach($rows as $row){
            $m = new $class();
            $m->sets($row, false);
            
            $ret[] = $m;
        }
        
        return $ret;
    }
    
    public function __construct(){
        $this->data = new stdClass();
    }
    
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
        
        $this->data->$key = $value;
        
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