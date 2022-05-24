<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "question".
 *
 * @property int $id
 * @property int $lecture_id
 * @property string|null $question
 * @property string|null $solution
 * @property int $is_deleted
 *
 * @property Lecture $lecture
 * @property TestQuestion[] $testQuestions
 */
class Question extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'question';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lecture_id'], 'required'],
            [['lecture_id', 'is_deleted'], 'integer'],
            [['solution'], 'string'],
            [['question'], 'string'],
            [['lecture_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lecture::className(), 'targetAttribute' => ['lecture_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lecture_id' => 'Lecture',
            'solution' => 'Solution',
            'question' => 'Question',
            'is_deleted' => 'Is deleted',
        ];
    }

    /**
     * Gets query for [[Lecture]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLecture()
    {
        return $this->hasOne(Lecture::className(), ['id' => 'lecture_id']);
    }

    /**
     * Gets query for [[TestQuestions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTestQuestions()
    {
        return $this->hasMany(TestQuestion::className(), ['question_id' => 'id']);
    }
}
