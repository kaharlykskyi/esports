<?php
namespace app\widgets;

use Yii;
use yii\base\Widget;

class Schedule extends Widget
{
    public $model;

    public function run()
    {
        $turs = $this->model->getSchedule(); 

        return $this->render('schedule',compact('turs'));
        
    }
}