<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->registerCssFile('css/tournament-statistics.css', ['depends' => ['app\assets\AppAsset']]);
$this->title = Yii::t('app','Tournament statistics');
?>

<?php 
    $func = function($data) {
    ob_start();
?>

<div class="name-content">
    <div class="info-stage">
        <?php if($data->state == 1): ?>
        <span class="started" >Started</span>
        <?php elseif($data->state == null): ?>
        <span class="uncoming" >Uncoming</span>
        <?php elseif($data->state == 2): ?>
        <span class="finihed" >Finihed</span>
        <?php endif; ?>
        <a href="/tournaments/public/<?=$data->id?>"><span class="overwatch" >Overwatch</span></a>
    </div>
   <h6><?=$data->name?></h6>
   <div class="t-prize" >
        <span>Tournament Prizes</span>
        <span><?=$data->prize_pool ? $data->prize_pool.'$': '--'?></span>
    </div>
</div>



<?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
    }
?>


<?php 
    $func_stage = function($data) {
    ob_start();
?>
    <?php if($data->state == 1): ?>
    <div class="mach-content">
        <?php  
        $match = $data->matchNext;
        if(is_object($match)): ?>
            <a href="/matches/public/<?=$match->id?>">
            <div class="mach-content">
                <h6>Next Match</h6>
                <div class="mach-logo" >
                    <img src="<?=$match->teamS->logo()?>" >
                    <img src="/images/tournaments/vs_finished.png" style="height:40px">
                    <img src="<?=$match->teamF->logo()?>" >
                </div>
                <div class="date">
                    <span><?=date('dS F Y, H:m', strtotime($match->date))?></span>
                </div>
            </div>
            </a>
        <?php endif; ?>
    </div>
    <?php endif; ?>


<?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
    }
?>

<?php 
    $func_game = function($data) {
    ob_start();
?>
<div class="tyr-game">
    <img src="/images/game/<?=$data->logo?>" style="height: 50px;" >
    <p style="font-size: 13px;font-weight: normal;" >geme in <?=$data->name?></p>
</div>
<?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
    }
?>

<div class="container">
    <h3 style="text-align: center;" ><?=Yii::t('app','Tournament statistics')?></h3>
    
       
    <div class="row">
        <div class="col-md-10 col-md-offset-1 search_tournament" style="margin-top:20px;margin-bottom:20px;">
            <form  method="GET">
            <div class="col-md-10">
                <input type="text" placeholder="Tournament name" name="SerchTournaments[name]" autocomplete="off" >
            </div>
            <div class="col-md-2">
                <button class="btn" ><span class="glyphicon glyphicon-search"></span> 
                    <?=Yii::t('app','Search')?>
                </button>
            </div>
            </form>
        </div>
    </div>
    <div class="box-body">
        <div class="blok-headre-table">
            <?php if(!isset($params['state'])):?>
                <div class="lenk-sot active" style="margin-left: -10px; ">
                    <a href="/tournaments">All tournaments</a>
                </div>
            <?php else: ?>
                <div class="lenk-sot" style="margin-left: -10px; ">
                    <a href="/tournaments">All tournaments</a>
                </div>
            <?php endif; ?>
            <?php if(!empty($params['state'])&& $params['state']==1):?>
                <div class="lenk-sot active" ">
                    <a href="/tournaments/?state=1">Tournaments started</a>
                </div>
            <?php else: ?>
                <div class="lenk-sot" ">
                    <a href="/tournaments/?state=1">Tournaments started</a>
                </div>
            <?php endif; ?>
            <?php if(isset($params['state'])&& $params['state']==0):?>
                <div class="lenk-sot active" ">
                    <a href="/tournaments/?state=0">Next tournaments</a>
                </div>
            <?php else: ?>
                <div class="lenk-sot"">
                    <a href="/tournaments/?state=0">Next tournaments</a>
                </div>
            <?php endif; ?>
            <?php if(!empty($params['state'])&& $params['state']==2):?>
                <div class="lenk-sot active" >
                    <a href="/tournaments/?state=2">Tournaments finished</a>
                </div>
            <?php else: ?>
                <div class="lenk-sot" ">
                    <a href="/tournaments/?state=2">Tournaments finished</a>
                </div>
            <?php endif; ?>
        </div>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'summary' => false,
            'tableOptions' =>['class' => 'table-statistic tournaments-table'],
            'showHeader'=> false,
             'pager' => [
                    'options' => [
                        'class' => 'pagination_new',
                    ],
                    'prevPageLabel' => '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
                    'nextPageLabel' => '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
            ],
            'columns' => [

                [
                    'attribute' => 'banner',
                   // 'label'=>'Tournament logo',
                    //'header' => Yii::t('app','Tournament logo'),
                    'content' => function($data) {
                        return "<img src='{$data->logo}' alt='logo'>";
                    }
                ],

                [
                    'attribute'=> 'name',
                    'label'=> Yii::t('app','Tournament name'),
                    'content' => function($data) use ($func) {
                        return $func($data);
                    },
                ],

                [                
                    'content' => function($data) use ($func_stage) {
                        return $func_stage($data);
                    },
                ],

                [
                    'attribute'=> 'game_id',
                    'label' => Yii::t('app','Game'),
                    'content' => function($data) use ($func_game) {
                        if (!is_object($data->game)) {
                            return 'Not game';
                        }
                        return $func_game($data->game);
                    },
                ],
            ],
        ]); ?>
    </div>
</div>