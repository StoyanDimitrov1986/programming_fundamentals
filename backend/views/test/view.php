<?php

/* @var $this yii\web\View */
/* @var $model common\models\Test */
/* @var $answers common\models\Answer[] */
/* @var $evaluations common\models\Evaluation[] */

$this->title = 'View Evaluated Test';
?>

<div class="test-update">
    <?= $this->render('_form', [
        'model' => $model,
        'answers' => $answers,
        'evaluations' => $evaluations,
        'mode' => 'view',
    ]) ?>
</div>
