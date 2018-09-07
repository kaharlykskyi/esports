<?php

namespace app\modules\forum\controllers;

use yii\web\Controller;
use app\models\Tournaments;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Teams;
use app\models\Games;
use app\models\User;
use app\models\TournamentTeam;
use app\models\UserTeam;
use app\models\TournamentUser;
use app\models\TournamentCupTeam;
use Yii;
use yii\web\HttpException;
/**
 * Default controller for the `forum` module
 */
class DefaultController extends Controller
{
	use \app\models\traits\UserTournament;
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex($id)
    {	
    	$model = Tournaments::findOne($id);
    	if (!is_object($model)) {
           throw new HttpException(404 ,'Page not found');
        }
        $users = self::gerUsers($model);
		if (!in_array(['id'=>Yii::$app->user->identity->id], $users)){
			throw new HttpException(404 ,'Page not found');
		}
       

        
        // echo "<pre>";
        // var_dump(in_array(['id'=>1], $users));
        // echo "</pre>";exit;

        return $this->render('index');
    }
}
