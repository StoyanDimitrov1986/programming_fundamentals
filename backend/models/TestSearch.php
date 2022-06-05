<?php

namespace backend\models;

use common\models\Test;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TestSearch represents the model behind the search form of `common\models\Test`.
 */
class TestSearch extends Test
{
    public $user;
    public $userEmail;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'lecture_id'], 'integer'],
            [['status', 'user', 'userEmail'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Test::find();

        $query->joinWith(['user']);


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['user'] = [
            'asc' => ['user.username' => SORT_ASC],
            'desc' => ['user.username' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['userEmail'] = [
            'asc' => ['user.email' => SORT_ASC],
            'desc' => ['user.email' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere(['in', 'test.status', [Test::STATUS_WAITING_EVALUATION, Test::STATUS_EVALUATED]])
            ->andFilterWhere(['test.status' => $this->status])
            ->andFilterWhere(['like', 'user.username', $this->user])
            ->andFilterWhere(['like', 'user.email', $this->userEmail]);


        return $dataProvider;
    }
}
