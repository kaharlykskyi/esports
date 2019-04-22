<?php 

namespace app\models\points;

use app\models\Tournaments;
use yii\helpers\Html;
use app\models\EventUser;
use app\models\UsetTeamTournament;
use app\models\Teams;
use app\models\User;
use app\models\UserPoint;

class PointsPoint {

	public static function getPoints (UserPoint $user_point)
    {
    	$user = $user_point->user;
    	$ball = $user->getBall();
    	$points = EventUser::find()->where([
    		'type' => EventUser::POINTS
    	])->one();
    	if(!is_object($points)) {
    		(new EventUser())->create($user->id, EventUser::POINTS, null, 1);
    		$user->addBall(54);
    	} elseif ($ball > 1000 && $points->event == 1) {
    		$points->event = 2;
    		$points->save(false);
    		$user->addBall(55);
    	} elseif ($ball > 5000 && $points->event == 2) {
    		$points->event = 3;
    		$points->save(false);
    		$user->addBall(56);
    	} elseif ($ball > 10000 && $points->event == 3) {
    		$points->event = 4;
    		$points->save(false);
    		$user->addBall(57);
    	} elseif ($ball > 15000 && $points->event == 4) {
    		$points->event = 5;
    		$points->save(false);
    		$user->addBall(58);
    	} elseif ($ball > 20000 && $points->event == 5) {
    		$points->event = 6;
    		$points->save(false);
    		$user->addBall(59);
    	} elseif ($ball > 50000 && $points->event == 6) {
    		$points->event = 7;
    		$points->save(false);
    		$user->addBall(60);
    	} elseif ($ball > 75000 && $points->event == 7) {
    		$points->event = 8;
    		$points->save(false);
    		$user->addBall(61);
    	} elseif ($ball > 100000 && $points->event == 8) {
    		$points->event = 9;
    		$points->save(false);
    		$user->addBall(62);
    	} elseif ($ball > 250000 && $points->event == 9) {
    		$points->event = 10;
    		$points->save(false);
    		$user->addBall(63);
    	} elseif ($ball > 500000 && $points->event == 10) {
    		$points->event = 11;
    		$points->save(false);
    		$user->addBall(64);
    	} elseif ($ball > 1000000 && $points->event == 11) {
    		$points->event = 12;
    		$points->save(false);
    		$user->addBall(65);
    	}
    }



}