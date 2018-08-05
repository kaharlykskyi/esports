<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login col-md-offset-4">
    <h1>Login</h1>
    <div class="customer-info">
        <form id="login-form" action="/login" method="post">
            <div class="row">
                <?= Html :: hiddenInput(\Yii :: $app->getRequest()->csrfParam, \Yii :: $app->getRequest()->getCsrfToken(), []);?>
                <div class="col-md-6">
                    <div class="item">
                        <label>
                            <span>Email <i>*</i></span>
                            <input type="email" name="LoginForm[email]" required>
                        </label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="item" style="padding-bottom: 0">
                        <label>
                            <span>Password <i>*</i></span>
                            <input type="password" name="LoginForm[password]" required>
                        </label>
                    </div>
                </div>
            </div>
            <div class="row login-error">
                <div class="col-lg-8"><p class="login-error_message"><?=$error?></p></div>
            </div>
            <div class="row">
                <div class="col-md-6" style="margin-bottom: 17px;">
                    <a href="/recovery" class="forgot-email">Forgot your password?</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary login-btn">Login&nbsp;&nbsp;<i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                </div>
            </div>
        </form>
    </div>
</div>
