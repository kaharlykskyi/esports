<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;
use yii\helpers\ArrayHelper;
use app\modules\admin\models\NewsCategory;
$this->registerCssFile('/dropify/dist/css/dropify.css');
$this->registerJsFile('/dropify/dist/js/dropify.js',['depends' => 'yii\web\JqueryAsset','position' => yii\web\View::POS_END]);

app\modules\admin\assets\NewsAsset::register($this);

    $script = "$('.dropify').dropify({
        defaultFile:'{$model->logo}',
        messages: {
            'default': 'Drag and drop a file here or click',
            'replace': 'Drag and drop or click to replace',
            'remove':  'Remove',
            'error':   'Ooops, something wrong happended.'
        }
    });";

$this->registerJs($script, yii\web\View::POS_END);


?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">News</div>
                <div class="card-body">
                    <div class="card-title">
                        <h3 class="text-center title-2"><?=$this->title?></h3>
                    </div>
                    <hr>
                    <label for=""></label>
                    <?php $form = ActiveForm::begin([
                        'validateOnBlur'=>false,
                        'errorCssClass' => false,
                    ]); ?>

                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(NewsCategory::find()->all(),'id','title'),
                        ['prompt' => 'Select a category','options' =>[ $model->category_id => ['Selected' => true]]
                    ])->label('Category')?>

                    <?=$form->field($model, 'logo_file')->fileInput(['class' => 'dropify','data-height'=>"200",'data-allowed-file-extensions'=>"jpg png jepg gif"]) ?>
                    <?= $form->field($model, 'description')->widget(TinyMce::className(), [
                        'options' => ['rows' => 12],
                        'language' => 'en',
                        'clientOptions' => [
                            'images_upload_url'=> '/admin/ajax/file-upload',
                            'plugins' => [
                                "image",
                                'advlist autolink lists link charmap  print hr preview pagebreak',
                                'searchreplace wordcount textcolor visualblocks visualchars code fullscreen nonbreaking',
                                'save insertdatetime media table contextmenu template paste image'
                            ],
                            'toolbar' => 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image'
                        ]
                        ]) ?>
                    <!-- <?// $form->field($model, 'state')->textInput() ?> -->
                    <div>
                        <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                            <!-- <i class="fa fa-lock fa-lg"></i>&nbsp; -->
                            <span id="payment-button-amount">Save News</span>
                            <span id="payment-button-sending" style="display:none;">Sending…</span>
                        </button>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
