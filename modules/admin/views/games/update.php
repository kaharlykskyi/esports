<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->registerCssFile('/dropify/dist/css/dropify.css');
$this->registerJsFile(
    '/dropify/dist/js/dropify.js',
    [
        'depends' => 'yii\web\JqueryAsset',
        'position' => yii\web\View::POS_END
    ]
);
$this->title = "Update game \"{$model->name}\"";
$script = "$('.dropify').dropify({
    defaultFile:'/images/game/{$model->logo}',
    messages: {
        'default': 'Drag and drop a file here or click',
        'replace': 'Drag and drop or click to replace',
        'remove':  'Remove',
        'error':   'Ooops, something wrong happended.'
    }
});";

$this->registerJs($script, yii\web\View::POS_END);
app\modules\admin\assets\GameAsset::register($this);

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
                    <label for=""></label>
                    <?php $form = ActiveForm::begin([
                        'id' => 'form-game',
                        'validateOnBlur'=>false,
                        'errorCssClass' => false,
                    ]); ?>

                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

                    <?=$form->field($model, 'logo_file')->fileInput(['class' => 'dropify','data-height'=>"200",'data-allowed-file-extensions'=>"jpg png jpeg gif"]) ?>
                    
                    <?php $active = ($model->status == 1) ? 'checked' : ''?>

                    <div class="row"> 
                        <div class="col-md-12">Enable / disable game
                            <label class="switch switch-3d switch-primary mr-3">
                                <input type="hidden" name="Games[status]" value="0">
                                <input type="checkbox" class="switch-input" <?=$active?> value="1" name="Games[status]" >
                                <span class="switch-label"></span>
                                <span class="switch-handle"></span>
                            </label>
                        </div>
                    </div>
                    <br>
                    <input type="hidden" name="Games[filed]" id="input-filed-ar">
                    <?php ActiveForm::end(); ?>
                    <div class="row"> 
                        <div class="col-md-12 " id="content-custom-field">
                            <?php $fields = json_decode($model->filed,true); 
                                if (is_array($fields)) {
                                    foreach ($fields as $count => $field) {
                            ?>
                            <div class="field-custom clearfix">
                                <span class="del-field" ><i class="fas fa-times"></i></span>
                                <div class="col-sm-1 number" ><?=$count+1?></div>
                                <div class="col-sm-11 s-type">
                                    <div class="col-sm-3 ">
                                        <label class="control-label mb-1 req">Field type</label>
                                        <select class="form-control-sm form-control select-type">
                                            <option value="vib" >Field type</option>
                                            <option value="select" <?=($field['type'] =='select')?'selected':''?> >Select
                                            </option>
                                            <option value="input" <?=($field['type'] =='input')?'selected':''?>>Input
                                            </option>
                                            <option value="checkbox" <?=($field['type'] =='checkbox')?'selected':''?> >Checbox
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3 ">
                                        <label class="control-label mb-1 req" >Name</label>
                                        <input class="form-control inp-name" value="<?=$field['name']??''?>">
                                    </div>
                                    <div class="col-sm-3 ">
                                        <label class="control-label mb-1 req">Title</label>
                                        <input class="form-control inp-title" value="<?=$field['title']??''?>">
                                    </div>
                                    <div class="col-sm-3 ">
                                        <label class="control-label mb-1">Class</label>
                                        <input class="form-control inp-class" value="<?=$field['class']??''?>">
                                    </div>
                                </div>
                                <div class="col-sm-10 col-sm-offset-1 tex-area-input">
                                    <?php if($field['type'] =='select'): ?>
                                        <div class="texarea">
                                            <label class="control-label mb-1 req">Option</label>
                                                <span>
                                                    Enter the value "opions" through the separator ";" for example ( apple;pear;peach )
                                                </span>
                                            <textarea row="6" class="form-control option-field" ><?php if(!empty($field['options'])){?><?=implode(";", $field['options']);?><?php } ?></textarea>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php }} ?>
                        </div>
                        <div class="help-block filed-error"></div>
                    </div>
                    <span class="btn btn-success add-field" id="add-field" >
                        <i class="fas fa-plus"></i>
                        Add custom field
                    </span>
                    <br><br>
                    <div style="margin-top: 20px;">
                        <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                            <span id="payment-button-amount">Save Game</span>
                            <span id="payment-button-sending" style="display:none;">Sending…</span>
                        </button>
                    </div>
                    <input type="hidden" value="1" id="update">
                </div>
            </div>
        </div>
    </div>
</div>