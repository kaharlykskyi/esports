<?php

use app\models\Tournaments;
    
$this->registerCssFile('/dropify/dist/css/dropify.css');
$this->registerCssFile('css/tournament-public.css', ['depends' => ['app\assets\AppAsset']]);
$this->registerJsFile('/js/profile/cup.js',[
    'depends' => 'yii\web\JqueryAsset',
    'position' => yii\web\View::POS_END
]);

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


<?php if(!empty($teams = $model->summBal)&&($model->format == Tournaments::LEAGUE_G)): ?>
        <div class="row">
            <?php 
                $groups = $model->system->getTeamsInGroup();
            ?>
        <?php  foreach ($groups as $key => $group): ?>
            <div class="col-md-12"> 
                <h6 style="text-align: center;"><?= Yii::t('app','GROUP') ?> <?=$key?></h6>
                <table class="standing-full">
                    <tr>
                        <th><?= Yii::t('app','club') ?></th>
                        <th><?= Yii::t('app','played') ?></th>
                        <th><?= Yii::t('app','won') ?></th>
                        <th><?= Yii::t('app','lost') ?></th>
                        <th><?= Yii::t('app','points') ?></th>
                        <th><?= Yii::t('app','form') ?></th>
                    </tr>
                    <?php  foreach ( $group as $team ): ?>
                        <tr>
                            <td class="up">
                                <span class="team">
                                    <img src="<?=$team->team->logo()?>" width="30" height="30" alt="team-logo"> 
                                </span>
                                <span><?=$team->team->name()?></span>
                            </td>
                            <td><?=$team->played?></td>
                            <td><?=$team->won?></td>
                            <td><?=$team->lost?></td>
                            <td class="points"><span><?=$team->summ_ball?></span></td>
                            <td class="form">
                                <?php $shel_arry = $team->shedule ;
                                    foreach ($shel_arry as $res): ?>
                                    <?php if($res): ?>
                                        <span class="win">w</span>
                                    <?php else:?>
                                        <span class="lose">l</span>
                                    <?php endif;?>
                                <?php endforeach; ?>
                            </td>  
                        </tr>
                    <?php endforeach; ?>
                </table>       
            </div>
        <?php endforeach; ?>
        </div>
<?php endif; ?>

<?php if(!empty($teams = $model->summBal)&&($model->format == Tournaments::SWISS || $model->format ==Tournaments::LEAGUE || $model->format == Tournaments::LEAGUE_P)): ?>
    
        <div class="row">
            <div class="col-md-12"> 
                <table class="standing-full">
                    <tr>
                        <th><?= Yii::t('app','club') ?></th>
                        <th><?= Yii::t('app','played') ?></th>
                        <th><?= Yii::t('app','won') ?></th>
                        <th><?= Yii::t('app','lost') ?></th>
                        <th><?= Yii::t('app','points') ?></th>
                        <th><?= Yii::t('app','form') ?></th>
                    </tr>
                    <?php  foreach ( $teams as $team ): ?>
                        <tr>
                            <td class="up">
                                <span class="team">
                                    <img src="<?=$team->team->logo()?>" width="30" height="30" alt="team-logo"> 
                                </span>
                                <span><?=$team->team->name()?></span>
                            </td>
                            <td><?=$team->played?></td>
                            <td><?=$team->won?></td>
                            <td><?=$team->lost?></td>
                            <td class="points"><span><?=$team->summ_ball?></span></td>
                            <td class="form">
                                <?php $shel_arry = $team->shedule ;
                                    foreach ($shel_arry as $res): ?>
                                    <?php if($res): ?>
                                        <span class="win">w</span>
                                    <?php else:?>
                                        <span class="lose">l</span>
                                    <?php endif;?>
                                <?php endforeach; ?>
                            </td>  
                        </tr>
                    <?php endforeach; ?>
                </table>       
            </div>
        </div>

<?php endif; ?>

<?php if(!empty($model->cup) && ($model->format != Tournaments::LEAGUE)): ?>
    <?php if($model->format > Tournaments::LEAGUE): ?>
        <div class="row">
             <div class="col-md-12">
                <h6 style="text-align: center;" >
                    <?= Yii::t('app','Teams in playoff') ?>
                </h6>
            </div>
        </div>
    <?php endif; ?>
    <div id="minimal" style="margin-top: 35px;" ></div>
<?php endif; ?>
<script>   
    <?=$script??''?>
</script>
