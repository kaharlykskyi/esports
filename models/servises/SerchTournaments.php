<?php

namespace app\models\servises;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Tournaments;
use app\models\TournamentTeam;
use app\models\UserTeam;

class SerchTournaments extends Tournaments
{

    public function rules()
    {
        return [
            [['id','game_id','created_at','state','rank'], 'integer'],
            [['name','banner'],'string'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        if (\Yii::$app->user->isGuest) {
            $query = Tournaments::find()->where(['tournaments.private' => 0]);
        } else {
            $query = Tournaments::find()->select('tournaments.*')
                ->joinWith('tournamentTeam.team.userTeams.user')
                ->where(['and',
                    ['tournament_team.status' => TournamentTeam::ACCEPTED],
                    ['in','user_team.status',[UserTeam::ACCEPTED, UserTeam::DUMMY]],
                    ['tournaments.private' => self::PRIVATE_T],
                    ['user_team.id_user' => \Yii::$app->user->identity->id]
                ])->orWhere(['tournaments.user_id' => \Yii::$app->user->identity->id])
                ->orWhere(['tournaments.private' => 0])
                ->groupBy('tournaments.id');
        }      

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [
                'defaultOrder' => ['created_at' => SORT_DESC ],
                'attributes' => [
                    'rank' => [
                        'asc' => ['rank' => SORT_ASC],
                        'desc' => ['rank' => SORT_DESC],
                    ],
                    'created_at'
                ]
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
