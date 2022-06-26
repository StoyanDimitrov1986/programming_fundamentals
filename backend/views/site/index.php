<?php

/** @var yii\web\View $this */

use yii\helpers\Url;

$this->title = '(Teacher) Programming fundamentals';
?>
<div class="site-index" style="margin-top: 10%">

    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">Welcome to Teacher's Panel</h1>
        <br>
        <?php if (Yii::$app->user->isGuest) {
            echo "<p><a class='btn btn-lg btn-success' href='" . Url::to('site/login') . "'>Login</a></p>";
        } else {
            echo "<p><a class='btn btn-lg btn-success' href='" . Url::to('test/index') . "'>Go to evaluation section</a></p>";
        } ?>
    </div>
</div>
