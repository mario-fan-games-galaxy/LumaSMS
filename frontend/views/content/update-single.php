<article class="content-update content-update-single">
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
					<p>
						Well gang, now that Halloween is out of the way, we have officially entered the Christmas season.
					</p>
					
					<p>
						This Christmas, Santa has brought all you nice boys and girls the present of an update. Yes, I'm Santa. You didn't know that?
					</p>
					
					<?=view('content/update-submissions')?>
					
					<p>
						...what? Thanksgiving?
					</p>
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

<h2 class="subheadline">
	Comments
</h2>

<ul class="list-comments">
	<li>
		<?=view('content/comment-small')?>
	</li>
	
	<li>
		<?=view('content/comment-small')?>
	</li>
	
	<li>
		<?=view('content/comment-small')?>
	</li>
</ul>

<?=view('content/pagination')?>