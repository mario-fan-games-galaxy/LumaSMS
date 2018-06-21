<?php
$view='form';
$login=[];

$username=isset($_POST['username'])?$_POST['username']:null;
$password=isset($_POST['password'])?$_POST['password']:null;
if(User::GetUser()){
	$view='already-logged-in';
}elseif(
	!empty($username) && !empty($password)
){
	$login=User::Login($username,$password);
	
	if($login['username'] && $login['password'] && $login['attempts']){
		$view='success';
	}
}

if($view == 'form'){
	// Check the number of attempts first
	$attempts_wait=DB()->prepare("
		SELECT l.date FROM " . setting('db_prefix') . "login_attempts AS l
		
		WHERE
		date > ?
		AND
		user_agent = ?
		AND
		ip = ?
		AND
		success = 0
		
		ORDER BY
		l.date
		ASC
		;
	");

	$attempts_wait->execute([
		time() - setting('login_attempts_wait'),
		$_SERVER['HTTP_USER_AGENT'],
		$_SERVER['REMOTE_ADDR']
	]);

	$attempts_wait=$attempts_wait->fetch(PDO::FETCH_OBJ)->date;

	$login['attempts_wait']=time() - ($attempts_wait + setting('login_attempts_wait'));
	
	if(!isset($login['attempts_number'])){
		// Check the number of attempts first
		$attempts=DB()->prepare("
			SELECT COUNT(*) AS count FROM " . setting('db_prefix') . "login_attempts AS l
			WHERE
			date > ?
			AND
			user_agent = ?
			AND
			ip = ?
			AND
			success = 0
			;
		");
		
		$attempts->execute([
			time() - setting('login_attempts_wait'),
			$_SERVER['HTTP_USER_AGENT'],
			$_SERVER['REMOTE_ADDR']
		]);
		
		$login['attempts_number']=$attempts=$attempts->fetch(PDO::FETCH_OBJ)->count;
	}
}
?>
<h1><?=lang('login-title')?></h1>

<div class="card">
	<div class="card-block">
		<?=view('login/' . $view,$login)?>
	</div>
</div>
