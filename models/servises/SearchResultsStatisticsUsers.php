<?php

namespace app\models\servises;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ResultsStatisticUsers;


class SearchResultsStatisticsUsers extends ResultsStatisticUsers
{

    public function rules()
    {
        return [
            [['id','team_id','victories','loss','user_id'], 'integer'],
            ['rate','safe'],
            ['created_at','string'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params,$alias)
    {
        $query = ResultsStatisticUsers::find()
            ->joinWith(['game','team','user'])
            ->where(['games.alias' => $alias]);

        // $query = (new \yii\db\Query())
        //     ->select('*')->from('users')
        //     ->leftJoin('results_statistic_users', 'results_statistic_users.user_id  = users.id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 10 ],
        ]);

        $dataProvider->setSort([
            'defaultOrder' => ['rate' => SORT_DESC],
            'attributes'=>[
                'rate',
                'victories',
                'loss',
                'team_id' => [
                    'asc' => ['teams.name' => SORT_ASC],
                    'desc' => ['teams.name' => SORT_DESC],
                ],
                'user_id' => [
                    'asc' => ['users.name' => SORT_ASC],
                    'desc' => ['users.name' => SORT_DESC],
                ],
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'created_at', $this->created_at]);

        return $dataProvider;
    }
}
