<?php

class Login {
    public static
        $skin = false,
        $user = false
    ;
    
    public static function init(){
        session_start();
        
        if(!empty($_SESSION['uid'])){
            $user = User::id($_SESSION['uid']);
            
            if(!$user){
                self::signOut();
            }else{
                self::signIn($user);
            }
        }
    }
    
    public static function authenticate($username, $password, $logIn = true){
        $user = User::first(
            ['where'=>'username = :username'],
            ['username' => $username],
            1
        );
        
        if(!$user){
            return false;
        }
        
        if(md5($password) != $user->f('password') && !self::passwordCheck($password, $user->f('password'))){
            return false;
        }
        
        if(!S()['users']['keepMD5'] && md5($password) == $user->f('password')){
            $user->set('password', self::passwordHash($password));
            $user->save();
        }
        
        if($logIn){
            self::signIn($user);
        }
        
        return true;
    }
    
    public static function signIn($user){
        $_SESSION['uid'] = $user->f('uid');
        
        self::$user = $user;
    }
    
    public static function signOut(){
        session_destroy();
        
        self::$user = false;
        
        session_start();
    }
    
    public static function passwordHash($password){
        return password_hash($password, PASSWORD_BCRYPT);
    }
    
    public static function passwordCheck($maybe, $hash){
        return password_verify($maybe, $hash);
    }
    
    public static function skin(){
        if(empty(self::$skin)){
            $id = S()['site']['defaultSkin'];
            
            if(self::$user && self::$user->f('skin') != 0){
                $id = self::$user->f('skin');
            }
            
            self::$skin = SiteSkin::id($id);
        }
        
        return self::$skin;
    }
}

?>