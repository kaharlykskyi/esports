<?php
namespace app\widgets;

use Yii;
use yii\base\Widget;

class Schedule extends Widget
{
    public $turs;

    public function run()
    {
        $turs = $this->turs;
        return $this->render('schedule',compact('turs'));
        
    }
}