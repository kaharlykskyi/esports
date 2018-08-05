<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

//$this->registerJsFile(\Yii::$app->request->baseUrl . '/dropify/dist/js/dropify.js',['depends' => 'yii\web\JqueryAsset']);
$script = "$('.dropify').dropify({
        messages: {
            'default': 'Drag and drop a file here or click',
            'replace': 'Drag and drop or click to replace',
            'remove':  'Remove',
            'error':   'Ooops, something wrong happended.'
        }
    });
            
    ";
//$this->registerJsFile(\Yii::$app->request->baseUrl .'/js/profile/formValid.js',['depends' => 'yii\web\JqueryAsset']);
$this->registerJs($script, yii\web\View::POS_END);
$this->registerCssFile(\Yii::$app->request->baseUrl .'/dropify/dist/css/dropify.css');
$this->registerCssFile(\Yii::$app->request->baseUrl .'/css/create-team.css');
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
        ]); ?>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <?= $form->field($model, 'name')->textInput(['class' => false]) ?>
                <?= $form->field($model, 'bacgraund')->fileInput(['class' => 'dropify','data-height'=>"300",'data-allowed-file-extensions'=>"jpg png jepg gif"]) ?>
              
              

                
               <?php //$form->field($model, 'game_id',['template' => '{input}'])->radioList(ArrayHelper::map($not_gemes, 'id', 'name')) ?>
                <?php //$form->field($model, 'captain')->textInput(['class' => false]) ?>
                <div class="row" >
                     <div class="col-md-12">
                       <!-- <div id="radios">
                        <?php //$i = 0; foreach($not_gemes as $value):
                            //$i++;
                        ?>
                            
                            <label for="input<//$i?>" class='game'  ></label>
                            <input id="input<$i?>" name="Teams[game_id]" type="radio" value="<$value->id?>">
                        <?php //endforeach; ?>
                        <span id="slider"></span>
                        </div>-->
                       
                       <div id="radios">
  <label for="input1" class='game'></label>
  <input  id="input1" name="radio" type="radio" />
  <label class='game' for="input2"></label>
  <input  id="input2" name="radio" type="radio" />
  <label class='game' for="input3"></label>
  <input  id="input3" name="radio" type="radio" />
  <label class='game' for="input4"></label>
  <input  id="input4" name="radio" type="radio" />
  <label class='game' for="input5"></label>
  <input  id="input5" name="radio" type="radio" />
 
  <span id="slider"></span>
</div>
                       
                     </div>
                </div>
                   
                <?= $form->field($model, 'website')->textInput(['class' => false]) ?>
            </div>
         </div>   
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div><!-- profile-createteam -->
