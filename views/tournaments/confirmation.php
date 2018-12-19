<?php

use yii\helpers\Html;
use app\models\Teams;
use Yii;

$this->title = Yii::t('app','Invitation to join the tournament');
$this->registerCssFile('css/tournament-public.css', ['depends' => ['app\assets\AppAsset']]);
$this->registerJsFile(\Yii::$app->request->baseUrl . '/js/profile/invitation.js',['depends' => 'yii\web\JqueryAsset','position' => yii\web\View::POS_END]);

    if (is_object($team_model)) {
        $members = $team_model->getMembers();
    } else {
        $members = [];
    }

    $script = "$.max_players = ".$tournament->max_players.";";
    $this->registerJs($script, yii\web\View::POS_END);

?>

<div class="container" style="margin-top: 50px;">
	<div class="row">
		<div class="col-md-6 col-md-offset-3 text-center" style="margin-bottom: 40px;">
            <h2><?=$this->title?></h2>
            <div class="col-md-12" style="margin-bottom: 20px;">
            	<div class="col-md-6 col-md-offset-3" style="margin-top:18px;font-size: 20px; " >
            		<h6>
                        <a href="/tournaments/public/<?=$tournament->id?>" target="_blank">
                            <b><?= $tournament->name ?></b>
                        </a>
                    </h6>
                    <p> 
                        <span class="cups_text" ><?=$tournament->cups[0]?></span>
                        <span class="cups_images" ><?=$tournament->cups[1]?></span>
                    </p>
                    <br>
            		<p class="invitation_game"> 
                        <img src="/images/game/<?=$tournament->game->logo?>" alt=""> 
                        <b><?=$tournament->game->name?></b>
                    </p>
            	</div>
            </div>
            <div class="col-md-12" style="margin-bottom: 20px;">
                <div  style="font-size: 20px; " >
                    <p><b><?=Yii::t('app','Rules')?>:</b></p> 
                    <p><?=$tournament->rules?></p>
                    <p><b>Tournament Prize</b></p> 
                    <p><?=$tournament->prizes?></p>
                </div>
            </div>
            <form method="POST" id="invitation_form" >
            	<?= Html::hiddenInput(\Yii::$app->getRequest()->csrfParam,\Yii::$app->getRequest()->getCsrfToken(),[]);?>
			<div class="col-md-6">
                <?php if (!is_object($team_model)): ?>
				    <input type="submit" class="btn" name="ACCEPT" value="<?=Yii::t('app','ACCEPT')?>" >
                <?php else: ?>
				    <a href="#myModalteam" class="btn btn-secusses btn_mobil" data-toggle="modal" ><?=Yii::t('app','ACCEPT')?></a>
                <?php endif; ?>
			</div>
			<div class="col-md-6">
				<input type="submit" name="DECLINE" class="btn btn-red" value="<?=Yii::t('app','DECLINE')?>" >
			</div>
			</form>
		</div>
	</div>
</div>


<div id="myModalteam" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>                
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" id='content_modal' style="margin-bottom:25px;"  >
                        <h6 style="text-align: center;padding:0;margin-top: 0;" >
                            <?=Yii::t('app','select players for the tournament')?>
                        </h6>
                        <p style="text-align: center;color:red;" >
                            <?=Yii::t('app','The number of participants must be equal')?> 
                            <?=$tournament->max_players?>
                        </p>
                        <div class="col-sm-offset-1 col-sm-10" style="height: 230px;overflow-y: auto;">
                        <?php foreach ($members as $key => $member): ?>
                            <?php if($member->fair_play > 80): ?>
                            <div class="col-sm-12" style="margin-bottom: 10px;">
                                <input  form="invitation_form" type="checkbox" name="uset_team_tournament[]" value="<?=$member->id?>" uncheckvalue="0" class="filter-check" id="check<?=$key?>" 
                                <?= $member->fair_play < 80 ? 'disabled':''?> >
                                <label for="check<?=$key?>"  class="input_checkbox" >
                                    <span style="font-size: 18px;position: relative;bottom: 5px;"><?=$member->name?></span>
                                </label>
                            </div>
                            <?php else: ?>
                                <div class="col-sm-12" style="margin-bottom: 10px;">
                                    <span style="font-weight:700;font-size:18px;position:relative;bottom:5px;margin-left: 33px;">
                                        <?=$member->name?>
                                        <span style="color:red;font-weight:normal;margin-left: 33px;" >
                                            <?=Yii::t('app','rating \'fair play\' below 80')?> 
                                        </span>
                                    </span>

                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?> 
                        </div>
                        <div class="col-sm-12 invitation_input_submit" style="display: none;">
                            <input type="submit" form="invitation_form" id="sub_accet" class="btn" name="ACCEPT" value="<?=Yii::t('app','ACCEPT')?>" >
                        </div>            
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



