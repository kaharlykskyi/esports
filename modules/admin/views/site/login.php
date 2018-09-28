<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = 'Login';

?>
<div class="login-wrap">
    <div class="login-content">
        <div class="login-logo">
            <a href="#">
                <img src="/images/admin/icon/logo.png" alt="CoolAdmin">
            </a>
        </div>
        <div class="login-form">
            <!-- <form action="" method="post"> -->
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
                <?= $form->field($model, 'login')->textInput(['class' => 'au-input au-input--full','placeholder'=>'Login']) ?>
                <?= $form->field($model, 'password')->passwordInput(['class' => 'au-input au-input--full','placeholder'=>'Password']) ?>
                <div class="login-checkbox">
                    <label>
                        <input type="checkbox" name="LoginForm[rememberMe]">Remember Me
                    </label>
                </div>
                <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">sign in</button>
            <?php ActiveForm::end(); ?>
            <!-- </form> -->
        </div>
    </div>
</div>