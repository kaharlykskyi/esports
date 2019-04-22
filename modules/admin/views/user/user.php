<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\widgets\Alert;

$this->title = "User: {$user->username}";

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header user-header alt bg-dark"> 
                    <div class="media" style="padding: 5px;">
                        <a href="/user/public/<?=$user->id?>">
                            <img class="align-self-center rounded-circle mr-3" 
                            style="width:85px; height:85px;border-radius: 50%;" 
                            src="<?=$user->avatar()?>">
                        </a>
                        <a href="/user/public/<?=$user->id?>">
                            <span style="font-size: 20px; font-weight: bold;margin-left:25px; " >
                                <?=$this->title?>
                            </span>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?=Alert::widget()?>
                    <div class="tab">    
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="active">
                                <a class="nav-item nav-link active show" id="nav-home-tab" data-toggle="tab" href="#nav-home" >
                                    Send a message
                                </a>
                            </li>
                            <li>    
                                <a class="nav-item nav-link " id="nav-profile-tab" data-toggle="tab" href="#nav-profile" >
                                    To ban
                                </a>
                            </li>
                            <li>    
                                <a class="nav-item nav-link " id="nav-strimer-tab" data-toggle="tab" href="#nav-strimer" >
                                    Streamer
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content pl-3 pt-2" id="nav-tabContent">
                            <div class="tab-pane fade active in" id="nav-home" >
                                <h3 style="padding: 25px 0;">Write a message to the player</h3>
                                <div class="cont">
                                    <?php $form = ActiveForm::begin([
                                        'validateOnBlur'=>false,
                                        'errorCssClass' => false,
                                        'action' => ['/admin/user/send-message']
                                    ]); ?>
                                    <?= $form->field($forma, 'subject')->textInput() ?>
                                    <?= $form->field($forma, 'user_id')
                                        ->hiddenInput(['value' => $user->id])
                                        ->label(false) 
                                    ?>
                                    <?= $form->field($forma, 'content')->textarea(['rows' => '6']) ?>
                                    <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                        <span id="payment-button-amount">Send message</span>
                                    </button>
                                    <?php ActiveForm::end(); ?>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-profile" >
                                <?php if ($user->isBaned()): ?>
                                    <div class="alert-danger alert" style="margin-top: 25px;">
                                        Player banned to <?=$user->ban_date?>
                                    </div>
                                <?php endif; ?>
                                <h3 style="padding: 25px 0;" >Ban player</h3>
                                <?php $formb = ActiveForm::begin([
                                    'validateOnBlur'=>false,
                                    'errorCssClass' => false,
                                    'action' => ['/admin/user/set-ban']
                                ]); ?>
                                <?= $formb->field($banform, 'day_ban')
                                    ->textInput([
                                        'type' => 'number',
                                        'min' => 1,
                                        'value' => 7
                                    ]) 
                                ?>
                                <?= $formb->field($banform, 'user_id')
                                    ->hiddenInput(['value' => $user->id])
                                    ->label(false) 
                                ?>
                                <?= $formb->field($banform, 'explanation')->textarea(['rows' => '6']) ?>
                                <button  class="btn btn-lg btn-danger">
                                    <span id="payment-button-amount">To ban</span>
                                </button>
                                <?php ActiveForm::end(); ?>
                            </div>
                            <div class="tab-pane fade" id="nav-strimer" >
                                
                                <h3 style="padding: 25px 0;" >Turn off the streamer</h3>
                                <?php $form_s = ActiveForm::begin([
                                    'validateOnBlur'=>false,
                                    'errorCssClass' => false,
                                    'action' => ['/admin/user/streamer']
                                ]); ?>
                                
                                <?php $active = ($user->role == $user::LEGENDARY) ? 'checked' : ''?>
                                <input type="hidden" name="user_id" value="<?=$user->id?>">
                                <div class="row"> 
                                    <div class="col-md-12">Enable / disable streame  
                                        <label class="switch switch-3d switch-primary mr-3">
                                            <input type="hidden" name="User[role]" value="0">
                                            <input type="checkbox" class="switch-input" <?=$active?> 
                                            value="<?=$user::LEGENDARY?>" name="User[role]" >
                                            <span class="switch-label"></span>
                                            <span class="switch-handle"></span>
                                        </label>
                                    </div>
                                </div>
                                <br>
                                
                                <button  class="btn btn-lg btn-info">
                                    <span >Submit</span>
                                </button>
                                <?php ActiveForm::end(); ?>
                            </div>
                        </div>
                    </div>                   
                </div>
            </div>
        </div>
    </div>
</div>