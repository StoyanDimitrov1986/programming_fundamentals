<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \common\models\Lecture;

/* @var $this yii\web\View */
/* @var $model common\models\Question */
/* @var $form yii\widgets\ActiveForm */

$lectureModel = new Lecture()
?>

<div class="question-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'lecture_id')
        ->dropDownList(ArrayHelper::map(
            $lectureModel::find()->asArray()->all(), 'id', 'name'),
            ['prompt' => '']
        )
        ->label('Lecture', ['required'=>true])
    ?>

    <?= $form->field($model, 'question')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'solution')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'is_deleted')->dropDownList([1 => 'Yes', 0 => 'No']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
