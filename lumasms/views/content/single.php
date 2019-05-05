<?php if(!empty($content)): ?>
    <?=view('content/' . $typeName . '/individual', [ 'content' => $content ])?>
<?php else: ?>
    <p>Content not found.</p>
<?php endif; ?>