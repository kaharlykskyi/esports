<?php

namespace app\models\servises;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Tournaments;


class SerchTournaments extends Tournaments
{

    public function rules()
    {
        return [
            [['id','game_id','created_at','state'], 'integer'],
            [['name','banner'],'string'],
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
            'sort'=> [
                'defaultOrder' =>
                 ['created_at' => SORT_DESC]
            ],
            'pagination' => [ 'pageSize' => 12 ],
        ]);

        // echo "<pre>";
        // print_r($params);
        // echo "</pre>";exit;

        $this->load($params);
        $this->my_load($params);
        
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if ($this->state == '0') {
            $query->andFilterWhere(['is', 'state', new \yii\db\Expression('null')]);
        } else {
            $query->andFilterWhere([
                'id' => $this->id,
                'created_at' => $this->created_at,
                'game_id' => $this->game_id,
                'state' => $this->state,
            ]);

        }

        //$query->andWhere(['is', ['state' => null]]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }

    private function my_load($params) 
    {
        if(isset($params['state'])) {
            $this->state = $params['state'];
        }
    }
}
