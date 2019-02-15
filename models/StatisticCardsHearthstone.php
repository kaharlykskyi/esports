<?php

namespace app\models;

use Yii;


class StatisticCardsHearthstone extends \yii\db\ActiveRecord
{
    public static $cards = [
        'DRUID',
        'HUNTER',
        'MAGE',
        'PALADIN',
        'PRIEST',
        'ROGUE',
        'SHAMAN',
        'WARLOCK',
        'WARRIOR'
    ];

    public $c;

    public static function tableName()
    {
        return 'statistic_cards_hearthstone';
    }

    public function rules()
    {
        return [
            [['user_id', 'cart_id'], 'integer'],
            [['user_id'], 'exist', 
                'skipOnError' => true, 
                'targetClass' => User::className(), 
                'targetAttribute' => ['user_id' => 'id']
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'cart_id' => 'Cart ID',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    public static function setCards($array)
    {
        $user = Yii::$app->user->identity;
        if(is_array($array)&&is_object($user)) {
            foreach ($array as $card) {
                $key = array_search($card, self::$cards);
                if($key !== false) {
                    $model = new self();
                    $model->user_id = $user->id;
                    $model->cart_id = $key+1;
                    $model->save();
                }
            }
        }
    }

    public function getImg () 
    {
        $nane_card = self::$cards[$this->cart_id-1];
        return "<img src='/images/game/hearthstone/{$nane_card}.png' title='{$nane_card}'>";
    }

    public function getNameCard () 
    {
        $nane_card = self::$cards[$this->cart_id-1];
        return $nane_card;
    }

    public  function getCardsUsers ()
    {
        return self::find()->select(['user_id'])
        ->where(['cart_id'=>$this->cart_id])
        ->groupBy('user_id')->count();
    }

    public static function getCardsStatistic ()
    {
        return self::find()->select(['cart_id','count(*) c '])->groupBy('cart_id')->orderBy('c DESC')->all();
    }

    public static function cardsStatisticOne ($id_user)
    {
        return self::find()->select(['cart_id','count(*) c '])
            ->where(['user_id' => $id_user])->groupBy('cart_id')->orderBy('c DESC')->one();
    }
    //SELECT cart_id, count(*) c FROM statistic_cards_hearthstone GROUP BY cart_id ORDER BY c DESC LIMIT 1;
}
