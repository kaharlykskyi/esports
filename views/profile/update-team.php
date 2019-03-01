<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\servises\FlagServis;
use app\models\SponsorTeam;

$this->registerCssFile('https://use.fontawesome.com/releases/v5.2.0/css/all.css');
$this->registerCssFile('css/team.css', ['depends' => ['app\assets\AppAsset']]);

$this->title = 'Update team';


$script = "$('.dropify').dropify({
        showRemove:false,
        height:200,
        defaultFile:'{$model->logo}',
        messages: {
            'default': '".Yii::t('app','Drag and drop a file here or click')."',
            'replace': '".Yii::t('app','Drag and drop or click to replace')."',
            'remove':  '".Yii::t('app','Remove')."',
            'error':   '".Yii::t('app','Ooops, something wrong happended.')."'
        }
    });

    $('.dropify1').dropify({
        showRemove:false,
        height:300,
        defaultFile:'{$model->background}',
        messages: {
            'default': '".Yii::t('app','Drag and drop a file here or click')."',
            'replace': '".Yii::t('app','Drag and drop or click to replace')."',
            'remove':  '".Yii::t('app','Remove')."',
            'error':   '".Yii::t('app','Ooops, something wrong happended.')."'
        }
    });

    $('.dropify3').dropify({
        showRemove:false,
        height:300,
        messages: {
            'default': '".Yii::t('app','Drag and drop a file here or click')."',
            'replace': '".Yii::t('app','Drag and drop or click to replace')."',
            'remove':  '".Yii::t('app','Remove')."',
            'error':   '".Yii::t('app','Ooops, something wrong happended.')."'
        }
    });
";

$this->registerJs($script, yii\web\View::POS_END);
$this->registerCssFile(\Yii::$app->request->baseUrl .'/dropify/dist/css/dropify.css');
$this->registerCssFile(\Yii::$app->request->baseUrl .'/css/create-team.css');
$this->registerCssFile(\Yii::$app->request->baseUrl .'/css/update-team.css');

?>


<section class="image-header" style="min-height: 450px; background: url(<?=$model->background?>) no-repeat right;background-size: cover;">
    <div class="player-photo geme-foto">
        <img class="img-responsive" src="/images/game/<?=$model->game->logo?>" alt="logo">
    </div>
    <div class="player-photo geme-foto" style="top:300px;">
        <img class="img-responsive" src="<?=FlagServis::getLinkFlag($model->capitans->country);?>" alt="flag">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="info">
                    <div class="wrap">
                    </div>
                </div>
            </div>  
        </div>
    </div>
    <div class="youplay-user-navigation">
        <div class="container">
            <ul class="flickity-enabled is-draggable nav nav-tabs" tabindex="0">
                <li id="activity-personal-li" class="active" >
                    <a id="user-activity" data-toggle="tab" href="#team">
                        Team                    
                    </a>
                </li>
                <!-- <li id="blogs-personal-li" >
                    <a id="user-blogs" data-toggle="tab" href="#players">
                        Players 
                    </a>
                </li> -->
                <li id="xprofile-personal-li" >
                    <a id="user-xprofile" data-toggle="tab" href="#sponsors">
                        Sponsors                    
                    </a>
                </li>
                <li id="seting-personal-li">
                    <a id="user-seting" data-toggle="tab" href="#history">
                        History 
                    </a>
                </li>  
            </ul>
        </div>
    </div>
</section>
<h1><?=Yii::t('app','Update team')?></h1>
<div class="container"  >
    <div class="row">
        <div class="col-md-12 ">
            <div class="tab-content my-tabs">
                <div id="team" class="tab-pane fade in active">
                    <div class="profile-createteam">
                        <div class="container leave-comment-wrap" >
                            <?php $form = ActiveForm::begin([
                                    'method' => 'post',
                                    'options' => ['enctype' => 'multipart/form-data'],
                                    'fieldConfig' => [
                                        'template' => '{label}{hint}{input}{error}',
                                        'labelOptions' => ['class' => 'col-sm-12 control-label'],
                                    ],
                                ]); 
                                $form->errorCssClass = false;
                                $form->validateOnBlur = false;
                                $form->successCssClass = false;
                            ?>
                            <div class="row">
                                
                                <div class="col-md-8 col-md-offset-2">
                                    <?= $form->field($model, 'name')->textInput(['class' => false]) ?>
                                    <?=$form->field($model, 'file')->fileInput(['class' => 'dropify','data-allowed-file-extensions'=>"jpg png jepg gif", 'accept'=>"image/jpeg,image/png,image/gif" ]) ?> 
                                    <?=$form->field($model, 'file1')->fileInput(['class' => 'dropify1','data-allowed-file-extensions'=>"jpg png jepg gif", 'accept'=>"image/jpeg,image/png,image/gif"  ]) ?> 
                                
                                   
                                    <?= $form->field($model, 'website')->textInput(['class' => false]) ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="col-sm-12 control-label" for="teams-background">
                                                <?=Yii::t('app','Capitan')?>
                                            </label>
                                            <div class="item select-show">
                                                <div class="fancy-select ">
                                                    <select class="basic" name="Teams[capitan]" required>
                                                        <?php foreach ($users as  $user) :?>
                                                             <option     <?= $user->id==$model->capitan ? 'selected' : '' ?>  value="<?=$user->id ?>"><?=$user->name?></option>
                                                        <?php endforeach; ?> 
                                                    </select>
                                                </div>    
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" id="game_idf" value="<?=$model->game_id?>" name="Teams[game_id]" >
                                </div>   
                                <div class="row">
                                    <div class="col-md-4 col-md-offset-2">
                                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary formbtn']) ?>
                                    </div> 
                                </div>
                                <?php ActiveForm::end(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="sponsors" class="tab-pane fade ">
                    <h2 style="text-align: center;">Sponsors</h2>
                    <div class="row ">
                        <div class="col-md-8 col-md-offset-2">
                            <a href="#modal-sponsor" class="btn btn-primary" data-toggle="modal" >
                                Add sponsor
                            </a>
                        </div>
                    </div>
                    <div id="modal-sponsor" class="modal fade">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" 
                                        data-dismiss="modal" aria-hidden="true">×
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-8 col-md-offset-2 modal-form">
                                            <h4 style="text-align: center;">Add Sponsor</h4>
                                            <?php $sponsor = new SponsorTeam(); 
                                                $form_s = ActiveForm::begin([
                                                    'id' => 'sponsor-form',
                                                    'method' => 'post',
                                                    'errorCssClass' => false,
                                                    'action' => '/team/add-sponsor',
                                                    'validateOnBlur' => false,
                                                    'successCssClass' => false,
                                                    'options' => ['enctype' => 'multipart/form-data'],
                                                ]);   
                                            ?>
                                            <input type="hidden" value="<?=$model->id?>" name='SponsorTeam[team_id]' >
                                            <?=$form_s->field($sponsor, 'img')->fileInput(['class' => 'dropify3','data-allowed-file-extensions'=>"jpg png jepg gif", 'accept'=>"image/jpeg,image/png,image/gif"  ])->label('Logo') ?>
                                            <?= $form_s->field($sponsor, 'name')->textInput(['class' => false]) ?>
                                            <?= $form_s->field($sponsor, 'site_url')->textInput(['class' => false]) ?>
                                            <?= Html::submitButton('Save', ['class' => 'btn btn-primary formbtn']) ?>
                                            <?php ActiveForm::end(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            
                                <?php foreach($model->sponsors as $sponsors): ?>
                                <div class="col-md-12 sponsor_list">
                                    <div class="col-sm-5">
                                        <div class="sponsor-logo">
                                            <img src="<?=$sponsors->logo?>" alt="logo">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-sm-offset-1">
                                       <p><b>Name: </b> <?=$sponsors->name?></p>
                                       <p><b>Site: </b> 
                                            <a href="<?=$sponsors->site_url?>"><?=$sponsors->site_url?></a>
                                        </p>
                                       <p>
                                            <a href="/team/delete-sponsor?id=<?=$sponsors->id?>" 
                                                class="btn edit-team btn-red" 
                                                onclick="return confirm('Confirm the deletion');"
                                                >Delete Sponsor</a>
                                        </p>
                                    </div>            
                                </div>
                                <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


