<?php

/* @var $this yii\web\View */
/* @var $model common\models\Test */
/* @var $answers common\models\Answer[] */
?>

<div class="test-update">
    <?= $this->render('_form', [
        'model' => $model,
        'answers' => $answers,
        'mode' => 'take'
    ]) ?>
</div>
