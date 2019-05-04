<?php

class Model {
    public static $table = '';
    
    private $data;
    
    public static function id($id){
        $primaryKey = 'id';
        
        if(!empty(static::$primaryKey)){
            $primaryKey = static::$primaryKey;
        }
        
        $class = get_called_class();
        
        $row = DB::fetch($sql = "SELECT * FROM " . static::$table . " WHERE $primaryKey = $id");
        
        $m = new $class();
        $m->sets($row);
        
        return $m;
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
        
        $sql = DB::paginate("SELECT " . $parts['cols'] . " FROM " . static::$table . $parts['where'] . $parts['order']);
        
        $rows = DB::fetchAll($sql);
        
        $class = get_called_class();
        
        $ret = [];
        
        foreach($rows as $row){
            $m = new $class();
            $m->sets($row);
            
            $ret[] = $m;
        }
        
        return $ret;
    }
    
    public function __construct(){
        $this->data = new stdClass();
    }
    
    public function sets($values){
        foreach($values as $key => $value){
            $this->set($key, $value);
        }
        
        return $this;
    }
    
    public function set($key, $value){
        $this->data->$key = $value;
        
        return $this;
    }
}

?>