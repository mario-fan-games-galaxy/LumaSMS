<article class="content-update-small">
	<div class="card">
		<div class="card-header flex flex-center">
			<h2 class="flex-grow">
				<a href="<?=url()?>/update">
					New Site Features
				</a>
			</h2>
			
			<div>
				<?=date('F j Y, g:i:sa')?>
			</div>
		</div>
		
		<div class="card-body">
			<div class="row">
				<div class="col-12 col-lg-3 col-xxl-2">
					<?=view('user/profile-small')?>
				</div><!-- .col-lg-3 -->
				
				<div class="col-12 col-lg-9 col-xxl-10">
					test
				</div><!-- .col-lg-9 -->
			</div><!-- .row -->
		</div><!-- .card-body -->
		
		<div class="card-footer">
			<ul class="list-update-meta-links flex flex-center">
				<li>
					<a href="<?=url()?>/update">
						View Comments (5)
					</a>
				</li>
				
				<li>
					<a href="<?=url()?>/update">
						Leave Comment
					</a>
				</li>
			</ul>
		</div><!-- .card-footer -->
	</div><!-- .card -->
</article>