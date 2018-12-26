<div class="pagination-links">
	<div class="row">
		<div class="col-6 col-lg-3 text-right text-lg-left pagination-column-previous">
			<a href="#" class="btn btn-primary">
				<span class="fas fa-angle-double-left"></span>
				
				Previous
			</a>
		</div>
		
		<div class="col-12 col-lg-6 text-center pagination-column-list">
			<ul class="list-pagination-links"><?php for($i=1; $i<10 + 1; $i++): ?>
				<li>
					<a href="#" class="btn btn-primary">
						<?=$i?>
					</a>
				</li>
			<?php endfor; ?></ul>
		</div>
		
		<div class="col-6 col-lg-3 text-left text-lg-right pagination-column-next">
			<a href="#" class="btn btn-primary">
				Next
				
				<span class="fas fa-angle-double-right"></span>
			</a>
		</div>
	</div>
</div>