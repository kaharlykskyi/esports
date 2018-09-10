<?php

    use app\widgets\Alert;
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use yii\helpers\Url;
    use yii\helpers\ArrayHelper;
    use kartik\datetime\DateTimePicker;
    use app\models\Tournaments;
?>


<?php $form = ActiveForm::begin([ 
    'validateOnBlur'=>false,  
    'options' => ['enctype' => 'multipart/form-data'],
    'fieldConfig' => [
        'template' => '{label}{hint}{input}{error}',
        'labelOptions' => ['class' => 'col-sm-12 control-label'],
    ],
]); 
$form->errorCssClass = false;
$form->successCssClass = false;
?>
<div class="row">
    <h4 style="text-align: center;"  >UPDATE TOURNAMENT</h4>
    <div class="alert_tour col-md-12" style="margin: 20px 0;font-size: 16px;" > <?=Alert::widget()?></div>

    <div class="col-md-12">
        <?= $form->field($model, 'name')->textarea(['rows' => 12, 'class' => false]) ?>
        
    </div>

        </div>   
        <div class="row">
            <div class="col-md-12">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary formbtn btn_mobil']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>