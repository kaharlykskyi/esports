<?php 

namespace app\models\events;

use app\models\ScheduleTeams;
use yii\helpers\Html;
use app\models\MessageUser;
use app\models\ResultsStatistics;
use app\models\TeamHistory;

class MatchEvent {

    public static function creationMatch ( ScheduleTeams $match) {
        self::sentMessage($match);
    }

    public static function played (ScheduleTeams $match) {
        PlayPoint::checkMatch($match);
        ResultsStatistics::addStatistic($match); 

        if ($match->results1 > $match->results2) {
            TeamHistory::setHistory('victoryMatch', $match, $match->team1);
            TeamHistory::setHistory('loseMatch', $match, $match->team2);
        } elseif ($match->results1 < $match->results2) {
            TeamHistory::setHistory('victoryMatch', $match, $match->team2);
            TeamHistory::setHistory('loseMatch', $match, $match->team1);
        }
        
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