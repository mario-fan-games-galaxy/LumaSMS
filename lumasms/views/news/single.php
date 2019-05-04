<?php if(!empty($post)): ?>
    <h2>
        <?=$post->f('title')?>
    </h2>
<?php else: ?>
    <p>Post not found.</p>
<?php endif; ?>