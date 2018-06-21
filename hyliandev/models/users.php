<?php

class Users extends Model {
	public static function Create($data=[]){
		if(in_array(true,$errors=Users::CreateError($data))){
			return $errors;
		}
		
		$q=DB()->prepare("
			INSERT INTO " . setting('db_prefix') . "users
			
			(
				gid,
				username,
				password,
				email,
				skin,
				registered_ip,
				cookie,
				join_date
			)
			
			VALUES (
				5,
				?,
				?,
				?,
				2,
				?,
				?,
				?
			);
		");
		
		$ret=$q->execute([
			preFormat($data['username']),
			User::Password($data['password']),
			$data['email'],
			$_SERVER['REMOTE_ADDR'],
			User::Cookie(),
			time()
		]);
		
		return $ret;
	}
	
	public static function CreateError($data=[]){
		$error=[
			'username'=>false,
			'password'=>false,
			'email'=>false
		];
		
		// Username
		if(empty($data['username'])){
			$error['username']='Username was empty';
		}elseif(strlen($data['username']) < setting('username_min_length')){
			$error['username']='Username was too short; must be ' . setting('username_min_length') . ' or more characters';
		}elseif(strlen($data['username']) > setting('username_max_length')){
			$error['username']='Username was too long; must be ' . setting('username_max_length') . ' or less characters';
		}elseif(Users::Read(['username'=>$data['username']])){
			$error['username']='That username already exists';
		}
		
		// Password
		if(empty($data['password'])){
			$error['password']='Password was empty';
		}elseif(strlen($data['password']) < setting('password_min_length')){
			$error['password']='Password was too short; must be ' . setting('password_min_length') . ' or more characters';
		}elseif(strlen($data['password']) > setting('password_max_length')){
			$error['password']='Password was too long; must be ' . setting('password_max_length') . ' or less characters';
		}
		
		// Email
		if(empty($data['email'])){
			$error['email']='Email was empty';
		}elseif(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
			$error['email']='Email was invalid';
		}elseif(Users::Read(['email'=>$data['email']])){
			$error['email']='An account with that email already exists';
		}
		
		return $error;
	}
	
	public static function Read($data=[]){
		$_sql=[];
		$values=[];
		foreach($data as $key=>$value){
			$values[]=$value;
			$_sql[]=$key . ' = ?';
		}
		
		$q=DB()->prepare(
			$sql="SELECT
			*
			FROM " . setting('db_prefix') . "users AS u
			
			WHERE
			" . implode(' AND ',$_sql) . "
			
			LIMIT 1
			;"
		);
		
		$q->execute($values);
		
		return $q->fetch(PDO::FETCH_OBJ);
	}
}

?>