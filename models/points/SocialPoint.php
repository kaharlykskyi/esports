<?php 

namespace app\models\points;

use app\models\Tournaments;
use yii\helpers\Html;
use app\models\EventUser;
use app\models\UsetTeamTournament;
use app\models\Teams;
use app\models\User;
use app\models\UserPoint;

class SocialPoint {

    public static function followLinks (User $user)
    {
        $referrer = \Yii::$app->request->referrer;
        if ($referrer) {
            $blah = parse_url($referrer);
            if (!empty($blah['host'])) {
                if(strpos($blah['host'], 'twitter') !== false) {
                    $count = self::getCountEvent (EventUser::TWITTER, $user->id);
                    if (($count%10) == 0) {
                        $user->addBall(71);
                    } else {
                        $user->addBall(66);
                    }   
                } elseif (strpos($blah['host'], 'facebook') !== false) {
                    self::getCountEvent (EventUser::FACEBOOK, $user->id);
                    $user->addBall(67);
                } elseif(strpos($blah['host'], 'youtube') !== false) {
                    self::getCountEvent (EventUser::YOUTUBE, $user->id);
                    $user->addBall(69);
                } elseif (strpos($blah['host'], 'twitch') !== false) {
                    self::getCountEvent (EventUser::TWITCH, $user->id);
                    $user->addBall(68);
                } elseif (strpos($blah['host'], 'instagram') !== false) {
                    self::getCountEvent (EventUser::INSTAGRAM, $user->id);
                    $user->addBall(70);
                }
            }

        }
    }

    public static function getCountEvent ($type, $user_id)
    {
        $event_user = EventUser::find()->where([
            'type' => EventUser::SOCIAL_NETWORKS,
            'type_event' =>  $type,
        ])->one();

        if (is_object($event_user)) {
            $event_user = new EventUser();
            $event_user->create($user_id, EventUser::SOCIAL_NETWORKS, $type, 1);
        } else {
            $event_user->event + 1;
        }
        return $event_user->event;
    }

}