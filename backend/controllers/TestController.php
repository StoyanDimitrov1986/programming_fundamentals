<?php

namespace backend\controllers;

use backend\models\TestSearch;
use common\models\Answer;
use common\models\Evaluation;
use common\models\Test;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * TestController implements the CRUD actions for Test model.
 */
class TestController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Evaluation related Test models.
     *
     * @return string
     */
    public function actionViewWaiting()
    {
        $searchModel = new TestSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Test model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $answers = [];
        $evaluations = [];

        foreach ($model->testQuestions as $testQuestion) {
            foreach ($testQuestion->answers as $answer) {
                $answers[$testQuestion->id] = $answer;
                $evaluations[$answer->id] = $answer->evaluation;
            }
        }

        return $this->render('view', [
            'model' => $model,
            'answers' => $answers,
            'evaluations' => $evaluations
        ]);
    }

    /**
     * Finds the Test model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Test the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Test::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Evaluate given Test model
     *
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionEvaluate($id)
    {
        $model = $this->findModel($id);

        $answers = [];
        $evaluations = [];


        if ($this->request->isPost) {
            $postEvaluations = $this->request->post('Evaluation');

            foreach ($postEvaluations as $postEvaluation) {
                $newEvaluation = new Evaluation();
                $newEvaluation->setAttributes($postEvaluation);
                $newEvaluation->save();
            }

            $model->status = Test::STATUS_EVALUATED;
            $model->save();

            return $this->redirect(['view', 'id' => $model->id]);
        }

        foreach ($model->testQuestions as $testQuestion) {
            foreach ($testQuestion->answers as $answer) {
                $answers[$testQuestion->id] = $answer;
                $evaluations[$answer->id] = new Evaluation();
            }
        }

        return $this->render('create', [
            'model' => $model,
            'answers' => $answers,
            'evaluations' => $evaluations,
        ]);
    }

    /**
     * Evaluate given Test model
     *
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionUpdateEvaluation($id)
    {
        $model = $this->findModel($id);

        $answers = [];
        $evaluations = [];


        if ($this->request->isPost) {
            $postEvaluations = $this->request->post('Evaluation');

            foreach ($postEvaluations as $postEvaluation) {
                $evaluation = Evaluation::find()->where(['answer_id' => $postEvaluation['answer_id']])->one();
                $evaluation->setAttributes($postEvaluation);
                $evaluation->save();
            }

            $model->status = Test::STATUS_EVALUATED;
            $model->save();

            return $this->redirect(['view', 'id' => $model->id]);
        }

        foreach ($model->testQuestions as $testQuestion) {
            foreach ($testQuestion->answers as $answer) {
                $answers[$testQuestion->id] = $answer;

                $evaluations[$answer->id] = $answer->evaluation;
            }
        }

        return $this->render('update', [
            'model' => $model,
            'answers' => $answers,
            'evaluations' => $evaluations,
        ]);
    }
}
