<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;
app\modules\admin\assets\NewsAsset::register($this);
$this->title = "Category create"
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"></div>
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
                    <div>
                        <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                            <!-- <i class="fa fa-lock fa-lg"></i>&nbsp; -->
                            <span id="payment-button-amount">Save category</span>
                            <span id="payment-button-sending" style="display:none;">Sending…</span>
                        </button>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>