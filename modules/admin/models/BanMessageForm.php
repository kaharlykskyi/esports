<?php 

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use app\models\User;
use app\models\MessageUser;


class BanMessageForm extends Model
{
    public $user_id;
    public $explanation;
    public $day_ban;

    public function rules()
    {
        return [
            
            [['explanation', 'user_id', 'day_ban'], 'required'],
            [['user_id', 'day_ban'], 'integer'],
            [['explanation'], 'string'],
            [['explanation'],'filter', 'filter' => 'strip_tags'],
            
        ];
    }

    public function attributeLabels()
    {
        return [
            'explanation' => 'Explanation of the ban',
            'day_ban' => 'Number of days for ban',
        ];
    }

    public function setBan ()
    {
        if ($this->validate()) {

            $user = User::findOne($this->user_id);
            if (is_object($user)) {
                $user->setBan($this->day_ban)->save(false);
                $message = new MessageUser();
                $message->writeTitle("Administrator: you were banned")
                    ->writeMessage(1, $this->user_id, $this->explanation);
                Yii::$app->mailer->compose()
                    ->setFrom([
                        Yii::$app->params['adminEmail'] => 'Site administrator Esports']
                    )->setTo([$user->email])
                    ->setSubject('You were banned')
                    ->setTextBody($this->explanation)->send();
                return true;
            }
            return false;
        }
        return false;
    }
}