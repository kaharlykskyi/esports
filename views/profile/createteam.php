<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


$this->title = 'Create team';
$this->params['breadcrumbs'][] = $this->title;

$script = "$('.dropify').dropify({
        messages: {
            'default': 'Drag and drop a file here or click',
            'replace': 'Drag and drop or click to replace',
            'remove':  'Remove',
            'error':   'Ooops, something wrong happended.'
        }
    });

    $('.dropify1').dropify({
        messages: {
            'default': 'Drag and drop a file here or click',
            'replace': 'Drag and drop or click to replace',
            'remove':  'Remove',
            'error':   'Ooops, something wrong happended.'
        }
    });
";

$this->registerJs($script, yii\web\View::POS_END);
$this->registerCssFile(\Yii::$app->request->baseUrl .'/dropify/dist/css/dropify.css');
$this->registerCssFile(\Yii::$app->request->baseUrl .'/css/create-team.css');
$this->registerJsFile(\Yii::$app->request->baseUrl . '/js/create-team.js',['depends' => 'yii\web\JqueryAsset','position' => yii\web\View::POS_END]);

?>
<div class="profile-createteam">
    <div class="container leave-comment-wrap" >
        <?php $form = ActiveForm::begin([
                
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
            <h1>Create team</h1>
            <div class="col-md-8 col-md-offset-2">
                <?= $form->field($model, 'name')->textInput(['class' => false]) ?>
                <?=$form->field($model, 'file')->fileInput(['class' => 'dropify','data-height'=>"200",'data-allowed-file-extensions'=>"jpg png jepg gif"]) ?> 
                <?=$form->field($model, 'file1')->fileInput(['class' => 'dropify1','data-height'=>"300",'data-allowed-file-extensions'=>"jpg png jepg gif"]) ?> 
                <div class="row" >
                     <div class="col-md-12">
                        <label class="col-sm-12 control-label" >Select game</label>
                        <div id="radios" class="clearfix">
                            <?php $i = 0; foreach($not_gemes as $value):
                                $i++;
                            ?>      
                            <label for="input<?=$i?>" class='game'  ><!-- style="background-image:url(../images/game/<?=$value->logo?>);" -->
                                <img class='geme_icon' src="../images/game/<?=$value->logo?>" alt="">
                            </label>
                            <input id="input<?=$i?>" name="Teams[game_id]" type="radio" value="<?=$value->id?>">
                        <?php endforeach; ?>
                        </div>
                        <div class="erroe-massage" style="display: none;">To select a game press the logo</div>                    
                     </div>
                </div>
                   
                <?= $form->field($model, 'website')->textInput(['class' => false]) ?>
            </div>
         </div>   
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary formbtn']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
