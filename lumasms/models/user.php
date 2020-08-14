<?php

class User extends Model {
    public static
        $primaryKey = 'uid',
        $table = 'tsms_users'
    ;
    
    public function __toString(){
        $view = view('users/profile-small', [ 'user' => $this ]);
        
        return $view ? $view : '';
    }
}

?>