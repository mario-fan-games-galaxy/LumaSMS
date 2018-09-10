<div class="topic">
    <div class="card-block">
        <div class="flex-center flex-row">
            <a href="<?=url()?>/forums/forum/<?=$pid?>/mark-as-read/<?=$tid?>" class="flex-column">
                <span class="fa fa-2x fa-star-o"></span>
            </a>
            
            <div class="flex-grow">
                <div class="flex-column flex-row">
                    <a href="<?=url()?>/forums/topic/<?=$tid?>-<?=titleToSlug($title)?>" class="flex-grow">
                        <?=$title?>
                    </a>
                    
                    <div class="flex-column">
                        Posted by <?=User::ShowUsername($user)?>
                        <?=displayDate($date)?>
                    </div>
                </div>
                
                <div class="flex-row">
                    <a href="<?=url()?>/forums/tag/<?=$tag?>" class="flex-column">
                        #<?=$tag?>
                    </a>
                    
                    <div class="flex-column">
                        <?=$views?>
                        Views
                    </div>
                    
                    <div class="flex-column">
                        <?=$replies?>
                        Replies
                    </div>
                    
                    <div class="flex-column">
                        Last post by
                        Lol
                    </div>
                    
                    <?php if (Topics::CanDelete([], $vars)) :
                        ?><div>
                        <a href="<?=url()?>/forums/topic/<?=$tid?>/delete" class="text-danger">
                            <span class="fa fa-times"></span>
                            Delete
                        </a>
                    <?php endif; ?>
                    
                    <?php if (Topics::CanEdit([], $vars)) :
                        ?><div>
                        <a href="<?=url()?>/forums/topic/<?=$tid?>/edit" class="text-warning">
                            <span class="fa fa-pencil"></span>
                            Edit
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>