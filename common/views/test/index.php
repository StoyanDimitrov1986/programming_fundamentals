<?php

use common\models\Test;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tests';
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
                    return  Html::a(Html::encode($model->lecture->name),'/index');
                },
            ],
            [
                'label' => 'Status',
                'value' => function (Test $model) {
                    return $model->getDisplayStatus();
                },
            ],
        ],
    ]); ?>


</div>
