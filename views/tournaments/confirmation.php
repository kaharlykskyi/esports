<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;


$this->title = 'Invitation to join the tournament';

?>

<div class="container" style="margin-top: 50px;">
	<div class="row">
		<div class="col-md-6 col-md-offset-3 text-center" style="margin-bottom: 40px;">
            <h2>Invitation to join the tournament</h2>
            <div class="col-md-12" style="margin-bottom: 60px;">
            	
            	<div class="col-md-6 col-md-offset-3" style="margin-top:18px;font-size: 20px; " >
            		<p><a href="/tournaments/public/<?=$team->id?>" target="_blank"><b><?=$tournament->name?></b></a></p>
            		<p><b><?=$tournament->game->name?></b></p>
            	</div>
            </div>
            <form method="POST" >
            	<?= Html::hiddenInput(\Yii::$app->getRequest()->csrfParam,\Yii::$app->getRequest()->getCsrfToken(),[]);?>
			<div class="col-md-6">
				<input type="submit" class="btn" name="ACCEPT" value="ACCEPT" >
				<!-- <a href="/profile/confirmation-team?confirmation_tokin=<?//$confirmation_tokin?>&status=2" class="btn">ACCEPT</a> -->
			</div>
			<div class="col-md-6">
				<input type="submit" name="DECLINE" class="btn btn-red" value="DECLINE" >
				<!-- <a href="/profile/confirmation-team?confirmation_tokin=<?//$confirmation_tokin?>&status=3" class="btn btn-red">DECLINE</a> -->
			</div>
			</form>
		</div>
	</div>
</div>