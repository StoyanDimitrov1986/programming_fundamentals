<?php
use yii\helpers\Url;

/** @var yii\web\View $this */

$this->title = 'Programming fundamentals';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">Welcome to<br>Programming Fundamentals</h1>

        <br>
        <?php if (Yii::$app->user->isGuest) {
            echo "<p><a class='btn btn-lg btn-success' href='" . Url::to('site/login') . "'>Login</a></p>";
        } else {
            echo "<p><a class='btn btn-lg btn-success' href='" . Url::to('test/index') . "'>Go to your tests</a></p>";
        } ?>
    </div>


</div>
