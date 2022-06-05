<?php

namespace frontend\controllers;

use common\models\Answer;
use common\models\Test;
use common\models\TestSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * TestController implements the CRUD actions for Test model.
 */
class TestController extends Controller
{
    /**
     * Lists all Test models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TestSearch();

        $searchModel->user_id = \Yii::$app->user->getId();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
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

        $testQuestionIds = [];

        foreach ($model->testQuestions as $testQuestion) {
            $testQuestionIds[] = $testQuestion->id;
        }

        /** @var Answer[] $results */
        $results = Answer::find()->where(['in', 'test_question_id', $testQuestionIds])->all();

        $answers = [];

        foreach ($results as $result) {
            $answers[$result->test_question_id] = $result;
        }

        return $this->render('view', [
            'model' => $model,
            'answers' => $answers,
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
     * Updates an existing TestQuestion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionTake($id)
    {
        $model = $this->findModel($id);
        $answers = [];

        if (!in_array($model->status,[Test::STATUS_IN_PROGRESS, Test::STATUS_NOT_STARTED])) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        if ($this->request->post('Answer')) {
            $postAnswers = $this->request->post('Answer');

            foreach ($postAnswers as $postAnswer) {
                $newAnswer = new Answer();
                $newAnswer->setAttributes($postAnswer);
                $newAnswer->save();

                $answers[$newAnswer->test_question_id] = $newAnswer;
            }

            $model->status = Test::STATUS_WAITING_EVALUATION;
            $model->save();

            return $this->redirect(['view', 'id' => $model->id]);
        }

        foreach ($model->testQuestions as $testQuestion) {
            $answers[$testQuestion->id] = new Answer();
        }

        $model->status = Test::STATUS_IN_PROGRESS;
        $model->save();

        return $this->render('take', [
            'model' => $model,
            'answers' => $answers
        ]);
    }
}

