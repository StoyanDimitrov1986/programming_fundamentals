<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "test".
 *
 * @property int $id
 * @property int $user_id
 * @property int $lecture_id
 * @property string|null $status
 *
 * @property Lecture $lecture
 * @property TestQuestion[] $testQuestions
 * @property User $user
 */
class Test extends \yii\db\ActiveRecord
{
    const STATUS_NOT_STARTED = 'not_started';
    const STATUS_NOT_SEND = 'not_send';
    const STATUS_WAITING_EVALUATION = 'waiting_evaluation';
    const STATUS_EVALUATED = 'evaluated';

    const DISPLAY_STATUSES = [
        self::STATUS_NOT_STARTED => 'Not started',
        self::STATUS_NOT_SEND => 'Not send',
        self::STATUS_WAITING_EVALUATION => 'Waiting evaluation',
        self::STATUS_EVALUATED => 'Evaluated',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'test';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'lecture_id'], 'required'],
            [['user_id', 'lecture_id'], 'integer'],
            [['status'], 'string'],
            [['lecture_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lecture::className(), 'targetAttribute' => ['lecture_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'lecture_id' => 'Lecture ID',
            'status' => 'Status',
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
        return $this->hasMany(TestQuestion::className(), ['test_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getDisplayStatus()
    {
        return self::DISPLAY_STATUSES[$this->status];
    }
}
