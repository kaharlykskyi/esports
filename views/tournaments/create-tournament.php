<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\datetime\DateTimePicker;



$this->title = Yii::t('app','Create tournaments');

$this->registerCssFile(\Yii::$app->request->baseUrl .'/css/create-team.css');
$this->registerCssFile(\Yii::$app->request->baseUrl .'/css/tournaments.css');
$this->registerJsFile(\Yii::$app->request->baseUrl . '/js/profile/tournaments.js',
    ['depends' => 'yii\web\JqueryAsset','position' => yii\web\View::POS_END]
);

?>
<div class="profile-createteam">
    <div class="container leave-comment-wrap" >
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
        <div class="row">
            <h1><?= $this->title ?></h1>
            <div class="col-md-8 col-md-offset-2">
                <?= $form->field($model, 'name')->textInput(['class' => false]) ?>
                
                <div class="row" >
                     <div class="col-md-12">
                        <label class="col-sm-12 control-label"  >
                            <?=Yii::t('app','Select the tournament game')?>
                        </label>
                        <div id="radios" class="clearfix">
                            <?php $i = 0; foreach($games as $value):
                                $i++;
                            ?>      
                            <label for="input<?=$i?>" class='game'  >
                                <!-- style="background-image:url(../images/game/<?=$value->logo?>);" -->
                                <img class='geme_icon' src="../images/game/<?=$value->logo?>" alt="">
                            </label>
                            <input id="input<?=$i?>" name="Tournaments[game_id]" class="input_radio_games" type="radio" value="<?=$value->id?>">
                        <?php endforeach; ?>
                        </div>
                        <div class="erroe-massage" style="display: none;">
                            <?= Yii::t('app','To select a game press the logo') ?>
                        </div>                    
                     </div>
                </div>

                <div class="row" id="format_campions_elimination" style="margin:25px -30px;" >
                    <label class="col-sm-12 control-label" style="padding-left: 50px;">
                            <?= Yii::t('app','Tournament format') ?>
                    </label>
                    <div class="col-md-12 "  style="margin-top:25px;">
                        <div class="col-md-4 ">
                            <div class="format_campions"  data-farmat ='c' >
                                <div class="container_img" >
                                    <img src="/images/profile/cup.png"  alt="cup">
                                </div>
                                <div style="padding-left: 25px;" >
                                    <h5><?= Yii::t('app','cup') ?></h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 ">
                            <div class="format_campions" data-farmat='l'>
                                <div class="container_img" style="padding-left: 10px;">
                                    <img src="/images/profile/league.png"  alt="league">
                                </div>
                                <div style="padding-left: 25px;" ><h5><?= Yii::t('app','league') ?></h5></div>
                            </div>
                        </div>
                        <div class="col-md-4 ">
                            <div class="format_campions"  data-farmat ='s' >
                                <div class="container_img" >
                                    <img src="/images/profile/swisss.png"  alt="swisss">
                                </div>
                                <div style="padding-left: 25px;" >
                                    <h5><?= Yii::t('app','Swiss') ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 col-md-offset-1" id="elimination" style="display:none;margin-top:25px;">
                        <div class="col-md-6 ">
                            <div class="format_campions elimination " data-farmat ='1'>
                                <div class="container_img" >
                                    <img src="/images/profile/single_elimination.png"  alt="s_cup">
                                </div>
                                <div style="flex-grow: " ><h5>
                                    <?= Yii::t('app','Single elimination') ?></h5>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 ">
                            <div class="format_campions elimination" data-farmat ='2'>
                                <div class="container_img" >
                                    <img src="/images/profile/duble_elimination.png"  alt="d_cup">
                                </div>
                                <div><h5><?= Yii::t('app','Double elimination') ?></h5></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 col-md-offset-1" id="match_schedule" style="margin-top:25px;display:none;">
                        <div class="row">
                            <div class="col-md-12" style="margin-bottom: 25px;" >
                                <div class="col-md-4 ">
                                    <div class="format_campions league default" data-farmat ='3'>
                                        <span><?= Yii::t('app','Regular League') ?></span> 
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="format_campions league" data-farmat ='4'>
                                        <span><?= Yii::t('app','Regular League + PlayOff') ?> </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="format_campions league" data-farmat ='5' >
                                        <span><?= Yii::t('app','Groups') ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12" >
                            <div class="grus_l" style="display: none;">
                                <p style="font-size: 15px;font-weight:bold;" >
                                    <?= Yii::t('app','Number of teams in the a group') ?>
                                </p>
                                <div class="item select-show"> 
                                <select class="basic" name="Tournaments[league_g]" required>
                                    <option  value="2" >2</option>
                                    <option  value="4" >4</option>
                                    <option  value="8" >8</option>
                                    <option  value="16" >16</option>
                                </select>
                                </div>
                            </div>
                            <div class="playoffs_l" style="display: none;" >
                                <p style="font-size: 15px;font-weight:bold;" >
                                    <?= Yii::t('app','Number of teams that go into the playoffs') ?>
                                </p>
                                <div class="item select-show"> 
                                    <select class="basic" name="Tournaments[league_p]" required>
                                        <option  value="2" >2</option>
                                        <option  value="4" >4</option>
                                        <option  value="8" >8</option>
                                        <option  value="16">16</option>
                                    </select>
                                </div>
                            </div>

                            <label>
                                <?= Yii::t('app','Match schedule') ?>
                            </label>
                            <div class="item select-show">
                                <select class="basic" name="Tournaments[match_schedule]" required>
                                    <option value="1"><?= Yii::t('app','one day') ?></option>
                                    <option value="3"><?= Yii::t('app','three days') ?></option>
                                    <option value="5"><?= Yii::t('app','five days') ?></option>
                                    <option value="7"><?= Yii::t('app','one week') ?></option>
                                    <option value="14"><?= Yii::t('app','two weeks') ?></option>
                                </select>
                            </div>         
                        </div>
                    </div>
                </div>
                <div >
                    <?= $form->field($model, 'format')->radioList(
                        [1 => 'a', 2 => 'b', 3 => 'c',4 => 'd', 5 => 'e', 6 => 'f']
                        ,['class' => 'radiolist_elimination']
                    )->label(false) ?>
                </div>
                <div>
                    <label style="padding-left: 20px;" ><?=Yii::t('app','Number of players per team') ?></label>
                    <div class="item select-show">
                        <select class="basic" name="Tournaments[max_players]" required>
                            <option value="1"><?=Yii::t('app','One player')?></option>
                            <option value="2"><?=Yii::t('app','Two players')?></option>
                            <option value="4"><?=Yii::t('app','Four players')?></option>
                        </select>
                    </div>      
                </div>
                <?= $form->field($model, 'rules')->textarea(['rows' => 12, 'class' => false]) ?>
                <?= $form->field($model, 'prizes')->textarea(['rows' => 12, 'class' => false]) ?>
                <?php  
                echo $form->field($model, 'start_date')->widget(DateTimePicker::className(),[
                    //'name' => 'datetime_10',
                    //'value' => '01-Jan-2017 10:00',
                    'options' => [  
                        'readonly' => true ,
                        'placeholder' => Yii::t('app','Select operating time ...'),
                        'autocomplete'=>"off",'class'=>'datainput',
                    ],
                    'convertFormat' => true,
                    'pluginOptions' => [
                        'format' => 'yyyy-MM-dd hh:i',
                        'startDate' => date("Y-m-d H:i"),//'2018-08-22 02:55'
                        'todayHighlight' => true
                ]]); ?>

                
                <div class="row"  style="margin:45px 0;" >
                    <div class="row">
                         <div class="col-md-offset-2 col-md-8" style="margin-bottom: 15px;">
                            <button style="width: 100%;"  id="stream_add"  class="btn btn-primary">
                                <?= Yii::t('app','Add new stream') ?>
                            </button> 
                        </div>
                    </div>
                    <div id="conteiner_stream">
                    </div>
                </div>


            </div>
         </div>   
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <?= Html::submitButton(Yii::t('app','Submit'), ['class' => 'btn btn-primary formbtn']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>


<div id="stream_zaotovka" style="display: none;">

    <div class="col-md-11 col-md-offset-1 plashka_stream">
        <div class="col-md-5" >
            <div class="form-group">
                <select class="form-control" name="stream_chanal[]" required>
                    <option value="1">Youtube</option>
                    <option value="2">Twitch</option>
                    <option value="3">Mixer</option>
                </select>
            </div>         
        </div>       
        <div class="col-xs-10 col-md-6">
            <input type="text" name="stream_url[]" 
                placeholder="<?= Yii::t('app','Enter stream link here') ?>" autocomplete="off">
        </div>
        <span class="close_stream">
        </span>          
    </div>   
</div>
