<?=view('content/sprites/small', [ 'content' => $content ])?>

<?=view('content/comments/list', [
    'comments' => $content->comments($commentsPage),
    'route' => 'content/sprites/view/' . $content->f('eid') . '/page',
    'commentsPage' => $commentsPage,
])?>