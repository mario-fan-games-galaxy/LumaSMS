<?php
$password=User::Password($_POST['password']);
?>

<div class="card">
	<div class="card-header">
		Input
	</div>
	
	<div class="card-block">
		<form method="post">
			<?=field([
				'name'=>'password',
				'title'=>'Password',
				'type'=>'password'
			])?>
			
			<input type="hidden" name="password-old" value="<?=$_POST['password']?>">
			
			<button type="submit" class="btn btn-primary">Submit</button>
		</form>
	</div>
	
	<div class="card-header">
		Output
	</div>
	
	<div class="card-block">
		<?=debug(
			$password,
			$password_old=User::Password($_POST['password-old']),
			User::PasswordMatch($_POST['password'],$password_old) ? 'Match' : 'Wrong password'
		)?>
	</div>
</div>