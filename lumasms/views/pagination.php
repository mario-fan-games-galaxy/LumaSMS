<div class="row auto-pagination py-2">
    <div class="col-12 col-lg-3 text-left">
        <?php if($page > 1): ?>
            <a href="<?=$route?>/<?=$page - 1?>" class="btn btn-primary">
                Previous
            </a>
        <?php endif; ?>
    </div>
    
    <div class="col-12 col-lg-6 text-center">
        <ul class="list-inline"><?php for($i = 0; $i < $pages; $i++): ?>
            <li class="list-inline-item p-2">
                <a href="<?=$route?>/<?=$i + 1?>" class="btn btn-primary<?php if($page == $i + 1): ?> disabled<?php endif; ?>">
                    <?=$i + 1?>
                </a>
            </li>
        <?php endfor; ?></ul>
    </div>
    
    <div class="col-12 col-lg-3 text-right">
        <?php if($page < $pages): ?>
            <a href="<?=$route?>/<?=$page + 1?>" class="btn btn-primary">
                Next
            </a>
        <?php endif; ?>
    </div>
</div>