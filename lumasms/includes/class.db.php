<?php

// Singleton database connection class
class DB {
    private static $PDO;
    
    private static function obj(){
        if(self::$PDO){
            die('recurring');
            return self::$PDO;
        }
        
        try {
            self::$PDO = new PDO(
                'mysql:host=' . S()['db']['host'] . ';dbname=' . S()['db']['dbname'],
                S()['db']['uname'],
                S()['db']['upass'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                ]
            );
        }
        catch(Exception $e){
            Fatality($e);
        }
        
        return self::$PDO;
    }
    
    public static function query($sql, $params = []){
        try {
            $q = self::obj()->prepare($sql);
            
            $q->execute($params);
            
            return $q;
        }
        catch(Exception $e){
            Fatality($e);
        }
        
        return false;
    }
    
    public static function fetch($sql, $params = []){
        try {
            if(is_string($sql)){
                $q = self::query($sql);
            }else{
                $q = $sql;
            }
            
            return $q->fetch();
        }
        catch(Exception $e){
            Fatality($e);
        }
        
        return false;
    }
    
    public static function fetchAll($sql, $params = []){
        try {
            if(is_string($sql)){
                $q = self::query($sql, $params);
            }else{
                $q = $sql;
            }
            
            return $q->fetchAll();
        }
        catch(Exception $e){
            Fatality($e);
        }
        
        return false;
    }
    
    public static function count($sql, $params = []){
        try {
            if(is_string($sql)){
                $q = self::query($sql, $params);
            }else{
                $q = $sql;
            }
            
            return $q->rowCount();
        }
        catch(Exception $e){
            Fatality($e);
        }
        
        return false;
    }
    
    public static function paginate($sql, $limit = 20, $page = 1){
        return $sql . " LIMIT " . ($limit * ($page - 1)) . ", " . $limit;
    }
    
    public static function newID(){
        return self::obj()->lastInsertId();
    }
}

?>