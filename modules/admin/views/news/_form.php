<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;
app\modules\admin\assets\NewsAsset::register($this);

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
                    <?php $form = ActiveForm::begin([
                        'validateOnBlur'=>false,
                        'errorCssClass' => false,
                    ]); ?>
                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
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
                    <?// $form->field($model, 'state')->textInput() ?>
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
