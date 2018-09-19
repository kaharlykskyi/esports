<?php


use yii\helpers\Html;

$this->title = 'Invitation to join the tournament';
$this->registerCssFile('css/tournament-public.css', ['depends' => ['app\assets\AppAsset']]);
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
            <form method="POST" >
            	<?= Html::hiddenInput(\Yii::$app->getRequest()->csrfParam,\Yii::$app->getRequest()->getCsrfToken(),[]);?>
			<div class="col-md-6">
				<!-- <input type="submit" class="btn" name="ACCEPT" value="ACCEPT" > -->
				<a href="#myModalteam" class="btn btn-secusses btn_mobil" data-toggle="modal" >ACCEPT</a>
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
                        <div class="col-md-12 " id='content_modal'>
                                               
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>