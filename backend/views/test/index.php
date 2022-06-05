<?php

use common\models\Lecture;
use common\models\Test;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Evaluating tests';
?>
<div class="test-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'label' => 'Lecture',
                'attribute' => 'lecture_id',
                'format' => 'raw',
                'value' => function (Test $model) {
                    if ($model->status === Test::STATUS_EVALUATED) {
                        return Html::a(Html::encode($model->lecture->name), Url::to(['/test/update-evaluation/', 'id' => $model->id]));
                    }

                    return Html::a(Html::encode($model->lecture->name), Url::to(['/test/evaluate/', 'id' => $model->id]));
                },
                'filter' => ArrayHelper::map(Lecture::find()->asArray()->all(), 'id', 'name'),
            ],
            [
                'label' => 'Student',
                'attribute' => 'user',
                'value' => 'user.username'
            ],
            [
                'label' => 'Student e-mail',
                'attribute' => 'userEmail',
                'value' => 'user.email'
            ],
            [
                'label' => 'Status',
                'attribute' => 'status',
                'filter' => [
                    Test::STATUS_WAITING_EVALUATION => Test::DISPLAY_STATUSES[Test::STATUS_WAITING_EVALUATION],
                    Test::STATUS_EVALUATED => Test::DISPLAY_STATUSES[Test::STATUS_EVALUATED]
                ],
                'value' => function (Test $model) {
                    $status = $model->getDisplayStatus();

                    if ($model->status !== Test::STATUS_EVALUATED) {
                        return $status;
                    }

                    $totalScore = [];

                    foreach ($model->testQuestions as $testQuestion) {
                        foreach ($testQuestion->answers as $answer) {
                            $totalScore[] = $answer->evaluation->score;
                        }
                    }

                    $avgScore = array_sum($totalScore) / count($totalScore);

                    return $status . ' (' . number_format($avgScore, '2') . ')';
                },
            ],
        ],
    ]); ?>
</div>
