<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use Yii;

$this->title = Yii::t('app','Change your password');

?>
<div class="site-login col-md-offset-4">
    <h1><?=Yii::t('app','Change your password')?></h1>
    <div class="customer-info">
        <form id="login-form" action="/change-password" method="post">
            <div class="row">
                <?= Html :: hiddenInput(\Yii :: $app->getRequest()->csrfParam, \Yii :: $app->getRequest()->getCsrfToken(), []);?>
                <input type="hidden" name="token" value="<?=$token?>">
                <div class="col-md-6">
                    <div class="item">
                        <label>
                            <span><?=Yii::t('app','Password')?> <i>*</i></span>
                            <input type="password" class="validate-password" name="password" required>
                        </label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="item" style="padding-bottom: 0">
                        <label>
                            <span><?=Yii::t('app','Repeat password')?> <i>*</i></span>
                            <input type="password" class="validate-password_repeat" name="password_repeat" required>
                        </label>
                    </div>
                </div>
            </div>
            <div class="row login-error">
                <div class="col-lg-8"><p class="password-error_message"></p></div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <button type="submit" style="display: none" class="btn btn-primary submit-btn">
                        <?=Yii::t('app','Continue')?>&nbsp;&nbsp;<i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php $this->registerJsFile(Yii::$app->request->baseUrl . '/js/passwordValidate.js',['depends' => 'yii\web\JqueryAsset']); ?>

