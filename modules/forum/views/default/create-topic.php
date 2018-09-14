<?php

    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use yii\helpers\Url;
    use yii\helpers\ArrayHelper;
    use app\models\Tournaments;
    use yii\widgets\Breadcrumbs;

    $this->title = 'Create Topic';
    $this->registerCssFile('css/forum/thread.css', ['depends' => ['app\assets\AppAsset']]);
    $this->params['breadcrumbs'][] = ['label' => 'Tournament', 'url' => ['/tournaments/public/'.$tour->id] ];
    $this->params['breadcrumbs'][] = ['label' => 'Forum', 'url' => ['/forum/'.$tour->id] ];
    $this->params['breadcrumbs'][] = ['label' => $this->title];
?>


<?php $form = ActiveForm::begin([ 
    'method' => 'post',
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
<div class="container">
    <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']?? [], ]) ?>
<div class="row" style="margin-bottom: 35px;">
    <h4 style="text-align: center;"  >CREATE TOPIC</h4>
    <div class="col-md-8 col-md-offset-2">
        <?= $form->field($model, 'name')->textInput(['class' => false]) ?> 
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary formbtn btn_mobil']) ?>
    </div>
</div>   

<?php ActiveForm::end(); ?>
</div>