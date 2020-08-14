<div class="user-profile-small">
	<div class="user-profile-small-username">
		<?=User::ShowUsername($vars)?>
	</div>

	<div class="user-profile-small-avatar">
		<img src="<?=$icon ? $icon : url() . '/theme/base/default-avatar.png'?>">
	</div>
	
	<div>
		<?=User::GetUserGroup()?>
	</div>

	<div class="user-profile-small-info">
		<div>
			<strong>Join Date:</strong>
			<?=displayDate($join_date)?>
		</div>
	</div>
</div>