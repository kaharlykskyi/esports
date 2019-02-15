<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Recovery';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login col-md-offset-4">
    <h1 style="padding-bottom: 15px;"><?=Yii::t('app','Forgot your password')?>?</h1>
    <?php if(!$message): ?>
    <p class="help-text"><?=Yii::t('app','Enter your email address and we\'ll send you instructions on how to reset your password')?></p>
    <?php endif; ?>
    <div class="customer-info">
        <form id="login-form" action="/recovery" method="post">
            <?php if($message): ?>
            <div class="row">
                <div class="col-md-7">
                    <div class="alert text-center alert-<?= $status ? 'success' : 'warning'?>">
                        <p class="text-center"><?=$message?></p>
                        <a href="/" class="btn btn-primary to-home">Home</a>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <?php if(!$message): ?>
            <div class="row">
                <?= Html :: hiddenInput(\Yii :: $app->getRequest()->csrfParam, \Yii :: $app->getRequest()->getCsrfToken(), []);?>
                <div class="col-md-6">
                    <div class="item">
                        <label>
                            <span>Email <i>*</i></span>
                            <input type="email" name="email" required>
                        </label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary login-btn"><?=Yii::t('app','Send')?> &nbsp;&nbsp;<i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                </div>
            </div>
            <?php endif; ?>
        </form>
    </div>
</div>
