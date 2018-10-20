<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Registration';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login col-md-offset-3">
    <h1>Sign in</h1>
    <div class="customer-info">
        <form id="login-form" action="/register" method="post">
            <?php if(!empty($errors)): ?>
            <div class="row">
                <div class="col-md-8">
                    <div class="alert alert-danger errors-list">
                        <?php foreach ($errors as $param => $error) { echo "<p>" . $error[0] . "<p>"; } ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <div class="row">
                <?= Html :: hiddenInput(\Yii :: $app->getRequest()->csrfParam, \Yii :: $app->getRequest()->getCsrfToken(), []);?>
                <div class="col-md-4">
                    <div class="item">
                        <label>
                            <span>Your name <i>*</i></span>
                            <input type="text" name="RegisterForm[name]" value="<?= isset($_POST['RegisterForm']['name']) ? $_POST['RegisterForm']['name'] : '' ?>" required>
                        </label>
                        <div class="col-lg-8"><p class="help-block help-block-error "></p></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="item">
                        <label>
                            <span>Username (nickname) <i>*</i></span>
                            <input type="text" name="RegisterForm[username]" value="<?= isset($_POST['RegisterForm']['username']) ? $_POST['RegisterForm']['username'] : ''?>" required>
                        </label>
                        <div class="col-lg-8"><p class="help-block help-block-error "></p></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="item">
                        <label>
                            <span>Email <i>*</i></span>
                            <input type="email" name="RegisterForm[email]" value="<?= isset($_POST['RegisterForm']['email']) ? $_POST['RegisterForm']['email'] : ''?>" required>
                        </label>
                        <div class="col-lg-8"><p class="help-block help-block-error "></p></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="item">
                        <label>
                            <span>Country <i>*</i></span>
                            <div class="fancy-select">
                                <select class="basic" name="RegisterForm[country]" required>
                                    <?php foreach($all_flag as $key => $flag):?>
                                        <option value="<?=$key?>"><?=$key?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="item">
                        <label>
                            <span>Password <i>*</i></span>
                            <input type="password" class="validate-password" name="RegisterForm[password]" required>
                        </label>
                        <div class="col-lg-8"><p class="help-block help-block-error "></p></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="item">
                        <label>
                            <span>Repeat password <i>*</i></span>
                            <input type="password" class="validate-password_repeat" required>
                        </label>
                        <div class="col-lg-8"><p class="help-block help-block-error "></p></div>
                    </div>
                </div>
            </div>
          
            <div class="row">
                <div class="col-md-12">
                    <div class="checkbox">
                        
                        <input type="checkbox" class='filter-check' id='check'>
                        <label for="check"  >
                            <span style="font-size: 18px;position: relative;bottom: 5px;">I agree to the 
                                <a href="GDPR Terms">GDPR Terms</a>
                            </span>
                        </label>
                    </div>
                </div>
            </div>  
            
            <div class="row login-error">
                <div class="col-lg-8"><p class="password-error_message"></p></div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary submit-btn">Sign in&nbsp;&nbsp;<i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                </div>
            </div>

        </form>
    </div>
</div>
<?php $this->registerJsFile(Yii::$app->request->baseUrl . '/js/passwordValidate.js',['depends' => 'yii\web\JqueryAsset']); ?>
