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
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Tournaments::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [
                'defaultOrder' =>
                 ['created_at' => SORT_DESC]
            ],
            'pagination' => [ 'pageSize' => 10 ],
        ]);

        $this->load($params);
        $this->my_load($params);
        
        if (!$this->validate()) {
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
