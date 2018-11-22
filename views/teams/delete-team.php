<?php
    use app\widgets\Alert;
    use yii\helpers\Html;
    use Yii;

    $this->title = 'Team-delete';
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="container" style="margin-top: 50px;">
	<div class="row">
		<div class="col-md-6 col-md-offset-3 text-center" style="margin-bottom: 40px;">
			<?php if (isset($delete)):?>
				<?=Alert::widget()?>
			<?php else: ?>
				<h2><?=Yii::t('app','Delete the command')?></h2>
            <div class="col-md-12" style="margin-bottom: 60px;">
            	<div class="col-md-5" class="clearfix" >
            		<a href="/teams/public/<?=$team->id?>" target="_blank">
	            		<img src="<?=$team->logo?>" style="border-radius: 50%;width: 100px;
	            		margin-right: 27px; float:right;">
	            	</a>
            	</div>
            	<div class="col-md-6 text-left" style="margin-top:18px;font-size: 20px; " >
            		<p><a href="/teams/public/<?=$team->id?>" target="_blank"><b><?=$team->name?></b></a></p>
            		<p><b><?=$team->game->name?></b></p>
            	</div>
            </div>
			<div class="col-md-6" style="text-align: center;">
				<form action="/teams/delete-team?confirmation_tokin=<?=$confirmation_tokin?>&id_user_team=<?=$id_user_team?>" method="POST">
					<?= Html::hiddenInput(\Yii::$app->getRequest()->csrfParam, \Yii::$app->getRequest()->getCsrfToken(), []);?>
					<button type="submit" class="btn btn-red" ><?=Yii::t('app','DELETE')?></button>
				</form>
			</div>
			<?php endif;?>
            
		</div>
	</div>
</div>