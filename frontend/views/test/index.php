<?php

use common\models\Test;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'My tests';
?>
<div class="test-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'label' => 'Lecture',
                'format' => 'raw',
                'value' => function (Test $model) {
                    if (!in_array($model->status, [Test::STATUS_IN_PROGRESS, Test::STATUS_NOT_STARTED])) {
                        return Html::a(Html::encode($model->lecture->name), Url::to(['/test/view/' , 'id' => $model->id]));
                    }

                    return Html::a(Html::encode($model->lecture->name), Url::to(['/test/take/' ,'id' => $model->id]));
                },
            ],
            [
                'label' => 'Status',
                'attribute' => 'status',
                'filter' => [
                    Test::STATUS_WAITING_EVALUATION => Test::DISPLAY_STATUSES[Test::STATUS_WAITING_EVALUATION],
                    Test::STATUS_EVALUATED => Test::DISPLAY_STATUSES[Test::STATUS_EVALUATED]
                ],
                'value' => function (Test $model) {
                    return $model->getDisplayStatusWithAvgScoreOrDisplayStatus();
                },
            ],
        ],
    ]); ?>


</div>
