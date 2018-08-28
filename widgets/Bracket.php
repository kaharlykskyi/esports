<?php
namespace app\widgets;

use Yii;

class Bracket extends \yii\bootstrap\Widget
{
	public function run()
    {
    	return $this->render('top-category');
    }
}