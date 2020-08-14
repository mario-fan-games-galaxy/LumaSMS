<div class="card">
	<div class="card-header">
		<?=User::ShowUsername($user)?>
		<small>
			<?=displayDate($date)?>
		</small>
	</div>
	
	<div class="card-block">
		<?=format($message)?>
	</div>
</div>