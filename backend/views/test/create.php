<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Test */
/* @var $answers common\models\Answer[] */
/* @var $evaluations common\models\Evaluation[] */

$this->title = 'Evaluate Test';
?>
<div class="test-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'answers' => $answers,
        'evaluations' => $evaluations,
        'mode' => 'create'
    ]) ?>

</div>
