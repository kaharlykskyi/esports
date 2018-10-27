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
        $query = ResultsStatisticUsers::find()->with('team','user')
            ->joinWith(['game','team','user'])
            ->where(['games.alias' => $alias]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [ 'pageSize' => 10 ],
        ]);
        $dataProvider->setSort([
            'defaultOrder' => ['rate'=>SORT_ASC],
            'attributes'=>[
                'rate'=>[
                    'asc' => ['`victories`/`loss`' => SORT_ASC,],
                    'desc' => ['`victories`/`loss`' =>  SORT_DESC],
                ],
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

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'created_at', $this->created_at]);

        return $dataProvider;
    }
}
