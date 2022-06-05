<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "evaluation".
 *
 * @property int $id
 * @property int $answer_id
 * @property string|null $remark
 * @property float|null $score
 *
 * @property Answer $answer
 */
class Evaluation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'evaluation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['answer_id', 'score'], 'required'],
            [['answer_id'], 'integer'],
            [['remark'], 'string'],
            [['score'], 'number'],
            [['answer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Answer::className(), 'targetAttribute' => ['answer_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'answer_id' => 'Answer ID',
            'remark' => 'Remark',
            'score' => 'Score',
        ];
    }

    /**
     * Gets query for [[Answer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnswer()
    {
        return $this->hasOne(Answer::className(), ['id' => 'answer_id']);
    }
}
