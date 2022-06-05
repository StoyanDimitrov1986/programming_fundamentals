<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Test */
/* @var $answers common\models\Answer[] */
/* @var $mode string */
/* @var $form yii\widgets\ActiveForm */


$this->title = 'Test: "' . $model->lecture->name . '"';
?>

<h1><?= Html::encode($this->title) ?></h1>
<h4><?= $model->getAttributeLabel('status') . ': ' . $model->getDisplayStatus() ?></h4>

<div class="test-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    foreach ($model->testQuestions as $key => $testQuestion) {
        echo $form->field($answers[$testQuestion->id], '[' . $testQuestion->id . ']' . 'answer')
            ->textarea(['rows' => 4, 'disabled' => $mode === 'view'])
            ->label(++$key . '. ' . $testQuestion->question->question);

        echo $form->field($answers[$testQuestion->id], '[' . $testQuestion->id . ']' . 'test_question_id')
            ->hiddenInput(['value' => $testQuestion->id])
            ->label(false);

        echo Html::tag('hr');
    }
    ?>

    <?php if ($mode === 'take'): ?>
        <div class="form-group">
            <?= Html::submitButton('Send', ['class' => 'btn btn-success']) ?>
        </div>

    <?php endif ?>

    <?php if ($mode === 'view'): ?>
        <?= Html::a('Back', ['test/index'], ['class' => 'btn btn-primary']) ?>
    <?php endif ?>

    <?php ActiveForm::end(); ?>
</div>
