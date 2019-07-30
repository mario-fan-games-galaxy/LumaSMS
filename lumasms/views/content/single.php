<?php if(!empty($content)): ?>
    <?=view('content/' . $typeName . '/individual', [ 'content' => $content, 'commentsPage' => $commentsPage, ])?>
<?php else: ?>
    <p>Content not found.</p>
<?php endif; ?>