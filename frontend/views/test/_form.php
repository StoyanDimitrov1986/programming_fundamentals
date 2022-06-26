<?php

use common\models\Test;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap4\Modal;

/* @var $this yii\web\View */
/* @var $model common\models\Test */
/* @var $answers common\models\Answer[] */
/* @var $mode string */
/* @var $form yii\widgets\ActiveForm */


$this->title = 'Test: "' . $model->lecture->name . '"';
?>

<div class="jumbotron jumbotron-fluid text-center bg-transparent" style="margin-bottom: 0">
    <h1><?= Html::encode($this->title) ?></h1>

    <h4><?= $model->getAttributeLabel('status') . ': ' . $model->getDisplayStatusWithAvgScoreOrDisplayStatus() ?></h4>
</div>

<div class="test-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php

    foreach ($model->testQuestions as $key => $testQuestion) {
        echo "<div class=\"row\">";

        if ($mode !== 'view') {
            echo "<div class=\"col-lg-12\">";
        } else {
            echo "<div class=\"col-lg-6\">";
        }

        $answer = $answers[$testQuestion->id];

        echo $form->field($answer, '[' . $testQuestion->id . ']' . 'answer')
            ->textarea(['rows' => $mode !== 'view' ? 4 : 14, 'disabled' => $mode === 'view'])
            ->label(++$key . '. ' . $testQuestion->question->question);

        echo $form->field($answer, '[' . $testQuestion->id . ']' . 'test_question_id')
            ->hiddenInput(['value' => $testQuestion->id])
            ->label(false);

        echo "</div>";

        if ($mode === 'view') {
            echo "<div class=\"col-lg-6\">";
            echo $form->field($testQuestion->question, '[' . $testQuestion->question->id . ']' . 'question_id')
                ->textarea([
                    'rows' => $model->status === Test::STATUS_WAITING_EVALUATION ? 14 : 4,
                    'value' => $testQuestion->question->solution,
                    'disabled' => true,
                ])
                ->label('Read more:', ['style' => 'color: orange']);

            if ($model->status === Test::STATUS_EVALUATED) {
                $evaluation = $answer->evaluation;

                echo $form->field($evaluation, '[' . $answer->id . ']' . 'remark')
                    ->textarea(['rows' => 4, 'value' => $evaluation->remark, 'disabled' => $mode === 'view'])
                    ->label('(Evaluation) Remark:', ['style' => 'color: orange']);

                echo $form->field($evaluation, '[' . $answer->id . ']' . 'score')
                    ->textInput(['type' => 'number', 'value' => $evaluation->score, 'min' => '2', 'max' => '6', 'step' => 'any', 'disabled' => $mode === 'view'])
                    ->label('(Evaluation) Score:', ['style' => 'color: orange', 'required ' => true]);

                echo $form->field($evaluation, '[' . $answer->id . ']' . 'answer_id')
                    ->hiddenInput(['value' => $answer->id, 'disabled' => $mode === 'view'])
                    ->label(false);
            }
            echo "</div>";
        }

        echo "</div>";

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

    <?php
    Modal::begin([
        'title' => 'Online compiler',
        'size' => Modal::SIZE_EXTRA_LARGE,
        'toggleButton' => [
            'tag' => 'button',
            'label' => 'Online compiler',
            'class' => 'btn btn-info',
            'style' => 'width: 140px; position: fixed; right: 15px; bottom: 15px; float: right !important;'
        ],
    ]);

    echo Html::label('You can test your solution here:');

    echo '<iframe src="https://onecompiler.com/php" height="600px" width="100%"></iframe>';

    Modal::end();
    ?>
</div>