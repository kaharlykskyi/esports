<?php

namespace app\models\servises;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Tournaments;

/**
 * SerchMaterials represents the model behind the search form of `\backend\models\Materials`.
 */
class SerchTournaments extends Tournaments
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','game_id','created_at'], 'integer'],
            ['name','string'],
            //[[, 'material'], 'safe'],
        ];
    }


    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }


    public function search($params)
    {
        $query = Tournaments::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['created_at'=>SORT_DESC]]
          
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'game_id' => $this->game_id,
            //'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);
            //->andFilterWhere(['like', 'material', $this->material]);

        return $dataProvider;
    }
}
