<h1><?=lang('register-title')?></h1>

<?php
if(User::GetUser()){
	echo view('register/already-logged-in');
}else{
	$errors=[];
	
	if(
		(
			!isset($_POST['username'])
			&&
			!isset($_POST['password'])
			&&
			!isset($_POST['email'])
		)
		||
		in_array(true,$errors=Users::CreateError($_POST))
	){
		echo view('register/form',['errors'=>$errors]);
	}else{
		$success=Users::Create([
			'username'=>$_POST['username'],
			'password'=>$_POST['password'],
			'email'=>$_POST['email']
		]);
		
		if($success){
			echo view('register/success');
		}else{
			echo view('register/error');
		}
	}
}
?>