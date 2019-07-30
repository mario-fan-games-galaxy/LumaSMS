<?php if(!empty($post)): ?>
    <?=view('news/individual', [ 'post' => $post, 'commentsPage' => $commentsPage ])?>
<?php else: ?>
    <p>Post not found.</p>
<?php endif; ?>