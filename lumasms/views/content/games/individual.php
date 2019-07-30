<?=view('content/games/small', [ 'content' => $content ])?>

<?=view('content/comments/list', [
    'comments' => $content->comments($commentsPage),
    'route' => 'content/games/view/' . $content->f('eid') . '/page',
    'commentsPage' => $commentsPage,
])?>