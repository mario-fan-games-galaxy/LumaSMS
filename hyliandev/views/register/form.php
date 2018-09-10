<form method="post" class="registration-form">

<div class="card">
	<div class="card-header">
		<?=lang('register-basic-info')?>
	</div>
	
	<div class="card-block">
		<?=field([
			'name' => 'username',
			'type' => 'text',
			'title' => 'Username',
			'minlength' => setting('username_min_length'),
			'maxlength' => setting('username_max_length'),
			'required' => true,
			'error' => $errors['username']
		])?>
		
		<?=field([
			'name' => 'password',
			'type' => 'password',
			'title' => 'Password',
			'minlength' => setting('password_min_length'),
			'required' => true,
			'error' => $errors['password']
		])?>
		
		<?=field([
			'name' => 'email',
			'type' => 'text',
			'title' => 'Email Address',
			'required' => true,
			'error' => $errors['email']
		])?>
	</div>
	
	<div class="card-header">
		Are you a robot?
	</div>
	
	<div class="card-block">
		<?=captcha()?>
	</div>
	
	<div class="card-header">
		<?=lang('misc-submit')?>
	</div>
	
	<div class="card-block">
		<button type="submit" class="btn btn-primary">
			<?=lang('register-button')?>
		</button>
		
		<button type="reset" class="btn btn-secondary">
			<?=lang('misc-reset')?>
		</button>
	</div>
</div>

</form>