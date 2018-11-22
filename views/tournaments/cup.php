<?php
use app\models\Tournaments;
use Yii;

    if(($model->format != Tournaments::LEAGUE)&&(!empty($model->cup))) {
        $script = "$.comandTeams = ".$model->cup.";";
        if ($model->format == Tournaments::DUBLE_E) {
            $script .= " $.tournament_duble = true;";
        } else {
            $script .= " $.tournament_duble = false;";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?=Yii::t('app','Cup')?></title>
    
    <link rel="stylesheet" href="/css/style.min.css">
    <link rel="stylesheet" href="/bracket/jquery.bracket.min.css">
    <link rel="stylesheet" href="/css/tournament-public.css">
    <script type="text/javascript" src="/js/library/jquery.js"></script>
    <script type="text/javascript" src="/bracket/jquery.bracket.min.js"></script>
    <script type="text/javascript" src="/js/profile/cup.js"></script>
</head>
<body>
    <div id="minimal" style="margin-top: 35px;" ></div>
    <script>
        <?=$script?>
    </script>
</body>
</html> 
