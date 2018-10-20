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
            [['id','team_id','victories','loss'], 'integer'],
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
            ->joinWith('game')
            ->where(['games.alias' => $alias]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [ 'pageSize' => 10 ],
        ]);
        $dataProvider->setSort([
            'defaultOrder' => ['rate'=>SORT_DESC],
            'attributes'=>[
                'rate'=>[
                    'asc' => ['`victories`/`loss`' => SORT_ASC,],
                    'desc' => ['`victories`/`loss`' =>  SORT_DESC],
                ],
                'victories',
                'loss',
                'user_id',
                'team_id',
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
