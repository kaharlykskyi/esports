<?php 

namespace app\models\events;

use app\models\ScheduleTeams;
use yii\helpers\Html;
use app\models\MessageUser;


class MatchEvent {

    public static function creationMatch ( ScheduleTeams $match) {
        self::sentMessage($match);
    }

    private static function sentMessage (ScheduleTeams $match) {

        $team_aS = "<a href='{$match->teamS->links()}'>{$match->teamS->name}</a>";
        $team_aF = "<a href='{$match->teamF->links()}'>{$match->teamF->name}</a>";
        $date = date(' d \of F, Y ',strtotime($match->date));
        $date_match = "The match will take place on {$date}.";
        $link = "<a href='/matches/public/{$match->id}>link</a>";

        $html_title = "match between teams {$team_aS} and {$team_aF}";
        $html_body = "{$date_match} To set the match results follow the {$link}";
        $recipient = $match->tournament->user_id;

        $messae = new MessageUser();
        $messae->writeType(MessageUser::MATCH)->writeTitle($html_title)
        ->writeMessage(null,$recipient, $html_body);
    }

}