<?php
$user = Users::Read(['uid' => $uid]);
?>

<div class="card">
    <div class="card-header">
        <?=$title?>
    </div>
    
    <div class="card-block">
        <div class="row">
            <div class="col-12 col-lg-3 text-center">
                <?=view('user/profile-small', $user)?>
            </div>
            
            <div class="col-12 col-lg-9">
                <?=format($message)?>
            </div>
        </div>
    </div>
</div>