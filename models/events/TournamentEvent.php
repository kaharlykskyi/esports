<?php 

namespace app\models\events;

use app\models\ScheduleTeams;
use app\models\Tournaments;
use yii\helpers\Html;
use app\models\EventUser;
use app\models\points\PlayPoint;
use app\models\points\TeamPoint;
use app\models\points\ManagePoint;
use app\models\servises\FairPlay;


class TournamentEvent {

    public static function creationTournamen (Tournaments $tournament) {
        ManagePoint::cteateTournament($tournament);
    }

    public static function played (Tournaments $tournament) {
        PlayPoint::checkTournament($tournament);
        TeamPoint::participeTournament($tournament);
        TeamPoint::winTournament($tournament);
        FairPlay::addRating($tournament);
    }

    

}