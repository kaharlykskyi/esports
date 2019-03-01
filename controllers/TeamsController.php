<?php

namespace app\controllers;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Teams;
use app\models\Games;
use app\models\UserTeam;
use yii\web\HttpException;
use Yii;
use app\models\User;
use app\models\UsetTeamTournament;


class TeamsController extends \yii\web\Controller
{

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex($slug)
    {
        $team = Teams::find()->where(['slug'=>$slug])->one();
        if (!is_object($team)) {
           throw new HttpException(404 ,'Page not found');
        }
        $members = $team->getMembers();
        return $this->render('team', compact(['team', 'members']));
    }


}
