<?php


use yii\helpers\Html;
use app\models\Teams;
$this->title = 'Invitation to join the tournament';
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
            <h2>Invitation to join the tournament</h2>
            <div class="col-md-12" style="margin-bottom: 60px;">
            	
            	<div class="col-md-6 col-md-offset-3" style="margin-top:18px;font-size: 20px; " >
            		<p><a href="/tournaments/public/<?=$tournament->id?>" target="_blank"><b><?= $tournament->name ?></b></a></p>
            		<p class="invitation_game"> <img src="/images/game/<?=$tournament->game->logo?>" alt=""> <b><?=$tournament->game->name?></b></p>
            	</div>
            </div>
            <form method="POST" id="invitation_form" >
            	<?= Html::hiddenInput(\Yii::$app->getRequest()->csrfParam,\Yii::$app->getRequest()->getCsrfToken(),[]);?>
			<div class="col-md-6">
                <?php if (!is_object($team_model)): ?>
				    <input type="submit" class="btn" name="ACCEPT" value="ACCEPT" >
                <?php else: ?>
				    <a href="#myModalteam" class="btn btn-secusses btn_mobil" data-toggle="modal" >ACCEPT</a>
                <?php endif; ?>
			</div>
			<div class="col-md-6">
				<input type="submit" name="DECLINE" class="btn btn-red" value="DECLINE" >
				
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
                        <h6 style="text-align: center;padding-top:0;margin-top: 0;" >select players for the tournament</h6>
                        <?php foreach ($members as $key => $member): ?>
                            <div class="col-sm-offset-2 col-sm-8" style="margin-bottom: 10px;">
                                <input  form="invitation_form" type="checkbox" name="uset_team_tournament[]" value="<?=$member->id?>" uncheckvalue="0" class="filter-check" id="check<?=$key?>" >
                                <label for="check<?=$key?>"  class="input_checkbox" >
                                    <span style="font-size: 18px;position: relative;bottom: 5px;"><?=$member->name?></span>
                                </label>
                            </div>
                        <?php endforeach; ?> 
                        <div class="col-sm-12 invitation_input_submit" style="display: none;">
                            <input type="submit" form="invitation_form" id="sub_accet" class="btn" name="ACCEPT" value="ACCEPT" >
                        </div>            
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>