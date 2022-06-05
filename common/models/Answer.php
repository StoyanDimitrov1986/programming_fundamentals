<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "answer".
 *
 * @property int $id
 * @property int $test_question_id
 * @property string|null $answer
 *
 * @property Evaluation $evaluation
 * @property TestQuestion $testQuestion
 */
class Answer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'answer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['test_question_id'], 'required'],
            [['test_question_id'], 'integer'],
            [['answer'], 'string'],
            [['test_question_id'], 'exist', 'skipOnError' => true, 'targetClass' => TestQuestion::className(), 'targetAttribute' => ['test_question_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'test_question_id' => 'Test Question ID',
            'answer' => 'Answer',
        ];
    }

    /**
     * Gets query for [[Evaluation]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEvaluation()
    {
        return $this->hasOne(Evaluation::className(), ['answer_id' => 'id']);
    }

    /**
     * Gets query for [[TestQuestion]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTestQuestion()
    {
        return $this->hasOne(TestQuestion::className(), ['id' => 'test_question_id']);
    }
}
