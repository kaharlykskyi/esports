<?php

namespace app\models\systems;

use app\models\Tournaments;
use app\models\User;
use app\models\BallMatch;
use app\models\ScheduleTeams;
use Yii;
use yii\db\Expression;

class DCupSystem extends CupSystem
{
	const WINNERS = 1;
	const LOSERS = 2;
	const FINALS = 3;

	protected function init ()
    {
        $this->createBracket(ScheduleTeams::FM_DCUP);
    }

    public function addMatch (ScheduleTeams $model) 
    {
        $this->summBal($model);

		if ($model->tur == 1 && $model->group == self::WINNERS) {
            $matches = ScheduleTeams::find()->where([
                'tournament_id' => $this->turnir->id,
                'tur'=>1,
                'group' => self::WINNERS,
            ])->all();
            $result = $this->winAndLoss($matches);
            if (!$result) {
                return false;
            }
            $this->writeStringTable($model, $result[0], ScheduleTeams::FM_DCUP, ($model->tur + 1), 1);
            $this->writeStringTable($model, $result[1], ScheduleTeams::FM_DCUP, 1, 2);
            $this->turnir->addCupDuble($result[0]);

        } elseif(($model->group == self::WINNERS && $model->tur >1)
        	||($model->group == self::LOSERS && !($model->tur%2==0)) ) {

            if ($model->group ==self::WINNERS) {
                $tur_winner = $model->tur;
                $tur_losers = (($model->tur-2)*2)+1;
            } elseif ($model->group == self::LOSERS) {
                $tur_winner = ($model->tur-1)/2+2;
                $tur_losers = $model->tur;
            }

            $matches_win = ScheduleTeams::find()->where([
                'tournament_id' => $this->turnir->id,
                'tur' => $tur_winner,
                'group' => self::WINNERS,
            ])->all();

            $matches_los = ScheduleTeams::find()->where([
                'tournament_id' => $this->turnir->id,
                'tur' => $tur_losers,
                'group' => self::LOSERS,
            ])->all();

            $result_win = $this->winAndLoss($matches_win);
            $result_los = $this->winAndLoss($matches_los);
            if ( empty($result_win) || empty($result_los)) {
                return false;
            }

            if (count($result_win[1]) == count($result_los[0])) {
                $los = $result_los[0];
                $win = $result_win[1];
                $arry_new_loss = [];
                $c = count($los);
                if (!(($tur_losers+1)%4==0)) {
                    $los = array_reverse($los);
                }
                for ($i=0; $i < $c; $i++) { 
                  $arry_new_loss[] = array_pop($los);
                  $arry_new_loss[] = array_pop($win);
                }

            }
            $this->writeStringTable($model, $result_win[0], ScheduleTeams::FM_DCUP, ($tur_winner+1), 1);
            $this->writeStringTable($model, $arry_new_loss, ScheduleTeams::FM_DCUP, ($tur_losers+1), 2);
            $this->turnir->addCupDuble(array_merge($result_win[0],$result_los[0]));

        } elseif($model->group == self::LOSERS && ($model->tur%2==0)) {
            $matches_los = ScheduleTeams::find()->where([
                'tournament_id' => $this->turnir->id,
                'tur' => $model->tur,
                'group' => 2,
            ])->all();
            $result_los = $this->winAndLoss($matches_los);
            if (!$result_los) {
                return false;
            }

            if (count($result_los[0]) == 1) {

                $matches_win = ScheduleTeams::find()->where([
                    'tournament_id' => $this->turnir->id,
                    'tur' => ($model->tur-2)/2+2,
                    'group' => self::WINNERS,
                ])->all();

                $result_win = $this->winAndLoss($matches_win);
                if (!$result_win) {
                    return false;
                }

                if (count($result_los[0]) ==  count($result_win[0])){
                    $final_arry = [];

                    $final_arry[] = array_pop($result_los[0]);
                    $final_arry[] = array_pop($result_win[0]);
                    $this->writeStringTable($model, $final_arry, ScheduleTeams::FM_DCUP, 1, 3);
                    $this->turnir->addCupDuble($final_arry);
                }
            } else {
                $this->writeStringTable($model, $result_los[0], ScheduleTeams::FM_DCUP, ($model->tur+1), 2);
                $this->turnir->addCupDuble($result_los[0]);
            }
        } elseif( $model->group == self::FINALS ) {
            $matches_final = ScheduleTeams::find()->where([
                'tournament_id' => $model->tournament_id,
                'tur' => 1,
                'group' => self::FINALS,
            ])->all();

            $matches_final = $this->winAndLoss($matches_final);
            if (!$matches_final) {
                return false;
            }
            $this->turnir->addCupDuble($matches_final[0]);
            $this->turnir->state = Tournaments::FINISHED;
            $this->turnir->save(false);
        }
    }

}

