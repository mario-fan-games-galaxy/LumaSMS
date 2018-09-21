<h1>Forums</h1>

<div class="card"><?php foreach (Forums::Read(['gid' => User::GetUserGroup()]) as $category) : ?>
    <?=view('forums/category', $category)?>
                  <?php endforeach; ?></div>