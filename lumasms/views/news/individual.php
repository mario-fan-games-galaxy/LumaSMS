<?=view('news/small', [ 'post' => $post ])?>

<?=view('content/comments/list', [
    'comments' => $post->comments($commentsPage),
    'route' => 'news/view/' . $post->f('nid') . '/page',
    'commentsPage' => $commentsPage,
])?>