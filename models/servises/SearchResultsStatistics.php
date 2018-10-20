<?php

namespace app\models\servises;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ResultsStatistics;


class SearchResultsStatistics extends ResultsStatistics
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
        $query = ResultsStatistics::find()->with('team')
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
                'team_id',
                'loss',
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
