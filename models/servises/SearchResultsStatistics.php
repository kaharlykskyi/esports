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
            [['id','team_id','victories','loss','rate'], 'integer'],
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
            ->joinWith(['game','team'])
            ->where(['games.alias' => $alias,'teams.single_user'=>null]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [ 'pageSize' => 10 ],
        ]);
        $dataProvider->setSort([
            'defaultOrder' => ['rate' => SORT_DESC],
            'attributes'=>[
                'rate',
                'victories',
                'team_id' => [
                    'asc' => ['teams.name' => SORT_ASC],
                    'desc' => ['teams.name' => SORT_DESC],
                ],
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
