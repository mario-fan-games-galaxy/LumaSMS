<div class="card">
	<div class="card-block">
		<?=debug(
			session_id(),
			bin2hex(openssl_random_pseudo_bytes(16)),
			$cstrong
		)?>
	</div>
</div>