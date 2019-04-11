<?php 

use app\widgets\ParticipantsData;
use yii\helpers\ArrayHelper;

$players = $model->getPlayers();
$this->title = 'Results';
?>

<h1 style="text-align: center;">
    <a href="/tournaments/public/<?=$model->id?>">
        Tournament '<?=$model->name?>'
    </a>
</h1>

<div class="champ-navigation">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="champ-nav-list">
                    <li class="active" >
                        <a href="#tournamentgrid" class="tournamentgrid" >
                            <?= Yii::t('app','Tournament grid') ?>
                        </a>
                    </li>
                    <li >
                        <a href="#participants">
                            <?= Yii::t('app','participants') ?>
                        </a>
                    </li>
                    <li><a href="#info"><?= Yii::t('app','Tournament info') ?></a></li>
                </ul>       
            </div>
        </div>
    </div>              
</div>
<div class="champ-tab-wrap tab-content">
    <div class="tab-item part-wrap tab-pane active" id="tournamentgrid">
        <div class="container" style="margin-top: 30px;">
            <?=$this->render('result',compact('model','full'))?>
        </div>
    </div>
    <div class="tab-item part-wrap tab-pane" id="participants">
        <div class="tab-item part-wrap tab-pane active" id="participants">
                <div class="part-list">
                <div class="container">
                    <div class="row">
                        <?php foreach ($players as $player): ?>
                            <div class="col-md-3">
                                <a href="<?= $player->links() ?>" class="item">
                                    <span class="logo">
                                        <img src="<?= $player->logo() ?>" width="80" height="80" alt="team-logo">
                                    </span>
                                    <span class="name"><?=$player->name()?></span>
                                </a>
                            </div>
                        <?php endforeach ;?>
                    </div>
                </div>
                </div>
        </div>
    </div>
    <div class="tab-item part-wrap tab-pane" id="info">
        <h3  style="text-align: center;" ><?=Yii::t('app','tournament information')?></h3>
        <div class="container" style="margin-bottom: 40px;">
            <div class="row">
                <div class="col-md-4 col-md-offset-2"><b>Game:</b></div>
                <div class="col-md-6"><?=$model->game->name?></div>
            </div>
            <div class="row">
                <div class="col-md-4 col-md-offset-2 "><b>Format tournament:</b></div>
                <div class="col-md-6">
                    <span>
                    <?php
                    switch ($model->format) {
                        case 1:
                        echo Yii::t('app','Cup (Single elimination)');
                        break;
                        case 2:
                        echo Yii::t('app','Cup (Duble elimination)');
                        break;
                        case 3:
                        echo Yii::t('app','League (Regular)');
                        break;
                        case 4:
                        echo Yii::t('app','League (Regular + Playoff)');
                        break;
                        case 5:
                        echo Yii::t('app','League (Group + Playoff)');
                        case 6:
                        echo Yii::t('app','Swiss system');
                        break;           
                    }
                    ?>
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-md-offset-2">
                    <b><?=Yii::t('app','Rules of the tournament')?>:</b>
                </div>
                <div class="col-md-6"><?=$model->rules?></div>
            </div>
            <div class="row">
                <div class="col-md-4 col-md-offset-2"><b><?=Yii::t('app','Tournament prizes')?>:</b></div>
                <div class="col-md-6"><?=$model->prizes?></div>
            </div>
            <div class="row">
                <div class="col-md-4 col-md-offset-2"><b><?=Yii::t('app','Prize pool')?> $:</b></div>
                <div class="col-md-6"><?=$model->prize_pool?></div>
            </div>

            <?php 
                $t_data = json_decode($model->data,true);
                $g_data = json_decode($model->game->filed,true);
                $g_data = ArrayHelper::index($g_data, 'name');
            ?>
            <?php if(is_array($t_data)): ?>
            <?php foreach($t_data as $key => $val): ?>
                <?php if(!empty($g_data[$key])): ?>
                    <div class="row">
                        <div class="col-md-4 col-md-offset-2">
                            <b><?=$g_data[$key]['title']?>:</b>
                        </div>
                        <div class="col-md-6">
                        <?php if ($g_data[$key]['type'] == 'checkbox') {
                                if (!(int)$val) {
                                    echo 'No';
                                } else {
                                    echo 'Yes';
                                }
                            } elseif (is_array($val)) {
                                if (empty($val[0])) {
                                    echo 'No';
                                } else {
                                    echo 'Yes';
                                }
                            } else {
                                echo $val;
                        }?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="row">
                        <div class="col-md-4 col-md-offset-2"><b>
                            <?=mb_convert_case(str_replace('_','',$key),MB_CASE_TITLE)?>:</b>
                        </div>
                        <div class="col-md-6">
                            <?php 
                                if (is_array($val)) {
                                    foreach ($val as $val_data) {
                                       echo '\''.$val_data.'\'&nbsp;&nbsp;&nbsp;';
                                    }
                                } else {
                                    echo $val.' ';
                                }
                            ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
           <?php endif; ?>
        </div>
    </div> 
</div>