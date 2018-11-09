<?php

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use app\models\User;


class FairPlayController extends Controller
{

    public function actionIndex()
    {
      
        $sql = 'UPDATE users SET fair_play=fair_play+1 WHERE fair_play < 100';
        for ($i=0; $i < 2; $i++) { 
            \Yii::$app->db->createCommand($sql)->execute();
        }
        return ExitCode::OK;
    }
}
