<form method="post">
	<?php if(isset($attempts) && !$attempts): ?>
		<div class="alert alert-danger">
			 You've made too many login attempts.
			 
			 Please try again <?=displayDate(time() - $attempts_wait)?>.
		</div>
	<?php else: ?>
		<?=field([
			'type'=>'text',
			'name'=>'username',
			'title'=>'Username',
			'required'=>true,
			'error'=>$unerror=(isset($_POST['username']) && !$username) ? 'Incorrect username' : ''
		])?>
		
		<?=field([
			'type'=>'password',
			'name'=>'password',
			'title'=>'Password',
			'required'=>true,
			'error'=>!$unerror && isset($_POST['password']) && !$password ? 'Incorrect password' : false
		])?>
		
		<?php if($attempts_number != 0): ?>
			<div class="alert alert-warning">
				You have
				<?=$attempts_number = (setting('login_attempts_max') - $attempts_number + 1)?>
				attempt<?=$attempts_number == 1 ? '' : 's'?> left!
			</div>
		<?php endif; ?>
		
		<div>
			<button type="submit" class="btn btn-primary">
				<?=lang('login-button')?>
			</button>
			
			<button type="reset" class="btn btn-secondary">
				<?=lang('misc-reset')?>
			</button>
		</div>
	<?php endif; ?>
</form>