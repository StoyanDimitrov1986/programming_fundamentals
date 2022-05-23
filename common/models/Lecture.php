<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lecture".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $is_deleted
 *
 * @property LectureQuestion[] $lectureQuestions
 */
class Lecture extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lecture';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_deleted'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'is_deleted' => 'Is Deleted',
        ];
    }

    /**
     * Gets query for [[LectureQuestions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLectureQuestions()
    {
        return $this->hasMany(LectureQuestion::className(), ['lecture_id' => 'id']);
    }
}
