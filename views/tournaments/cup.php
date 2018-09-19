<?php

    use app\widgets\Alert;
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use yii\helpers\Url;
    use yii\helpers\ArrayHelper;
    use kartik\datetime\DateTimePicker;
    use app\widgets\Schedule;
    use app\models\Tournaments;
    $this->title = 'Cup';

    $this->registerCssFile('css/tournament-public.css', ['depends' => ['app\assets\AppAsset']]);
    $this->registerJsFile(\Yii::$app->request->baseUrl . '/js/profile/cup.js',['depends' => 'yii\web\JqueryAsset','position' => yii\web\View::POS_END]);

     if(($model->format != Tournaments::LEAGUE)&&(!empty($model->cup))) {
        $script = "$.comandTeams = ".$model->cup.";";
        if ($model->format == Tournaments::DUBLE_E) {
            $script .= " $.tournament_duble = true;";
        } else {
            $script .= " $.tournament_duble = false;";
        }
        $this->registerJs($script, yii\web\View::POS_END);
    }
?>

<div id="minimal" style="margin-top: 35px;" ></div>