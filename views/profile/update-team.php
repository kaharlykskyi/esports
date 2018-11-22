<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use Yii;

$this->title = 'Update team';
$this->params['breadcrumbs'][] = $this->title;

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
";

$this->registerJs($script, yii\web\View::POS_END);
$this->registerCssFile(\Yii::$app->request->baseUrl .'/dropify/dist/css/dropify.css');
$this->registerCssFile(\Yii::$app->request->baseUrl .'/css/create-team.css');
//$this->registerJsFile(\Yii::$app->request->baseUrl . '/js/profile/update-team.js',['depends' => 'yii\web\JqueryAsset','position' => yii\web\View::POS_END]);

?>
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
            <h1><?=Yii::t('app','Update team')?></h1>
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
            <!-- <div class="col-md-4 conteiner_btn" style="padding-left: 150px;">
                <button class="btn btn-red" id="delete" data-modeel-id="<?// $model->id ?>" >Delete the team</button>
            </div> -->
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
