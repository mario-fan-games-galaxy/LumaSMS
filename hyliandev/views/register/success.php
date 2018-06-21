<div class="card">
	<div class="card-block">
		<?=lang('register-success')?> <?=User::ShowUsername(Users::Read(['username'=>$_POST['username']]))?>!
		
		<br><br>
		
		<a href="<?=url()?>/login/">Click here</a> to log in.
	</div>
</div>