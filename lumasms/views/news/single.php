<?php if(!empty($post)): ?>
    <?=view('news/individual', [ 'post' => $post ])?>
<?php else: ?>
    <p>Post not found.</p>
<?php endif; ?>