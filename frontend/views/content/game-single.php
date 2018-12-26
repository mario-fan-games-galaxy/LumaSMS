<article class="content-game content-game-single">
	<div class="card">
		<h2 class="card-header">
			Preview
		</h2><!-- .card-header -->
		
		<div class="card-body">
			<div class="row">
				<div class="col-12 col-lg-8 offset-lg-2">
					<?php for($i=0; $i<3; $i++): ?>
						<input type="radio" name="screenshot-selected" id="screenshot-selected-<?=$i?>" value="<?=$i?>"<?php if($i == 0): ?> checked<?php endif; ?> hidden>
					<?php endfor; ?>
					
					<ul class="list-screenshots-large"><?php for($i=0; $i<3; $i++): ?>
						<label for="screenshot-selected-<?=$i?>">
							<div class="thumbnail thumbnail-blur" style="background-image: url('<?=url()?>/assets/content/games/game<?=$i?>screen0.png');"></div>
						</label>
					<?php endfor; ?></ul>
					
					<ul class="list-screenshots row"><?php for($i=0; $i<3; $i++): ?>
						<li class="col-6 col-lg-3 col-xxl-2">
							<label for="screenshot-selected-<?=$i?>">
								<div class="thumbnail thumbnail-blur" style="background-image: url('<?=url()?>/assets/content/games/game<?=$i?>screen0.png');"></div>
							</label>
						</li>
					<?php endfor; ?></ul>
				</div><!-- .col-lg-3 -->
				
				<div class="col-12 col-lg-8 offset-lg-2">
					<div class="content-game-single-meta">
						<div class="content-game-score text-shadow-3D">
							<span class="fas fa-star"></span>
							<span class="fas fa-star"></span>
							<span class="fas fa-star"></span>
							<span class="far fa-star"></span>
							<span class="far fa-star"></span>
						</div>
					</div>
					
					<div class="content-game-single-description">
						<h2>
							This is a pretty cool game and stuff
						</h2>
						
						<p>
							Legend tells of an ancient treasure hidden within a temple.
							Play as an unnamed toad as he attempts to get his hands on
							this treasure. But be warned, any treasure worth having is
							usually guarded well...
						</p>
						
						<p>
							Toad and the Ancient Keys is a small metroidvania game that I
							created for a Super Comp. This particular version includes
							enhancements such as tweaked level design, a save feature and
							configurable controls. Enjoy.
						</p>
					</div>
				</div><!-- .col-lg-9 -->
			</div><!-- .row -->
		</div><!-- .card-body -->
		
		<h2 class="card-header">
			Reviews
		</h2><!-- .card-header -->
		
		<div class="card-body">
			<ul class="list-game-reviews">
				<li>
					<?=view('content/review-small')?>
				</li>
				
				<li>
					<?=view('content/review-small')?>
				</li>
				
				<li>
					<?=view('content/review-small')?>
				</li>
			</ul>
		</div><!-- .card-body -->
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