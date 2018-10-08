<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\datetime\DateTimePicker;


$this->title = 'Create tournaments';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile(\Yii::$app->request->baseUrl .'/css/create-team.css');
$this->registerCssFile(\Yii::$app->request->baseUrl .'/css/tournaments.css');
$this->registerJsFile(\Yii::$app->request->baseUrl . '/js/profile/tournaments.js',['depends' => 'yii\web\JqueryAsset','position' => yii\web\View::POS_END]);

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
            <h1>Create tournament</h1>
            <div class="col-md-8 col-md-offset-2">
                <?= $form->field($model, 'name')->textInput(['class' => false]) ?>
                
                <div class="row" >
                     <div class="col-md-12">
                        <label class="col-sm-12 control-label" >Select the tournament game</label>
                        <div id="radios" class="clearfix">
                            <?php $i = 0; foreach($games as $value):
                                $i++;
                            ?>      
                            <label for="input<?=$i?>" class='game'  ><!-- style="background-image:url(../images/game/<?=$value->logo?>);" -->
                                <img class='geme_icon' src="../images/game/<?=$value->logo?>" alt="">
                            </label>
                            <input id="input<?=$i?>" name="Tournaments[game_id]" class="input_radio_games" type="radio" value="<?=$value->id?>">
                        <?php endforeach; ?>
                        </div>
                        <div class="erroe-massage" style="display: none;">To select a game press the logo</div>                    
                     </div>
                </div>

                <div class="row" id="format_campions_elimination" style="margin:25px 0;" >
                   
                    <label class="col-sm-12 control-label" >Tournament format</label>
                    
                    <div class="col-md-10 col-md-offset-1 "  style="margin-top:25px;">
                        <div class="col-md-6 ">
                            <div class="format_campions"  data-farmat ='c' >
                                <div class="container_img" >
                                    <img src="/images/profile/cup.png"  alt="cup">
                                </div>
                                <div style="padding-left: 25px;" ><h5>cup</h5></div>
                            </div>
                        </div>

                        <div class="col-md-6 ">
                            <div class="format_campions" data-farmat='l'>
                                <div class="container_img" style="padding-left: 10px;">
                                    <img src="/images/profile/league.png"  alt="league">
                                </div>
                                <div style="padding-left: 25px;" ><h5>league</h5></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 col-md-offset-1" id="elimination" style="display:none;margin-top:25px;">
                        <div class="col-md-6 ">
                            <div class="format_campions elimination " data-farmat ='1'>
                                <div class="container_img" >
                                    <img src="/images/profile/single_elimination.png"  alt="s_cup">
                                </div>
                                <div style="flex-grow: " ><h5>Single elimination</h5></div>
                            </div>
                        </div>

                        <div class="col-md-6 ">
                            <div class="format_campions elimination" data-farmat ='2'>
                                <div class="container_img" >
                                    <img src="/images/profile/duble_elimination.png"  alt="d_cup">
                                </div>
                                <div><h5>Double elimination</h5></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-10 col-md-offset-1" id="match_schedule" style="margin-top:25px;display:none;">
                        <div class="row">
                            <div class="col-md-12" style="margin-bottom: 25px;" >
                                <div class="col-md-4 ">
                                    <div class="format_campions league default" data-farmat ='3'>
                                        <span>Regular League</span> 
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="format_campions league" data-farmat ='4'>
                                        <span>Regular League + PlayOff </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="format_campions league" data-farmat ='5' >
                                        <span>Groups</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12" >
                            <div class="grus_l" style="display: none;">
                                <p style="font-size: 15px;font-weight:bold;" >Number of teams in the a group</p>
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
                                <p style="font-size: 15px;font-weight:bold;" >Number of teams that go into the playoffs</p>
                                <div class="item select-show"> 
                                    <select class="basic" name="Tournaments[league_p]" required>
                                        <option  value="2" >2</option>
                                        <option  value="4" >4</option>
                                        <option  value="8" >8</option>
                                        <option  value="16">16</option>
                                    </select>
                                </div>
                            </div>

                            <label>Match schedule</label>
                            <div class="item select-show">
                                <select class="basic" name="Tournaments[match_schedule]" required>
                                    <option value="1">one day</option>
                                    <option value="3">three days</option>
                                    <option value="5">five days</option>
                                    <option value="7">one week</option>
                                    <option value="14">two weeks</option>
                                </select>
                            </div>         
                        </div>

                    </div>
                </div>
                <div >
                    <?= $form->field($model, 'format')->radioList([1 => 'a', 2 => 'b', 3 => 'c',4 => 'd', 5 => 'e'],['class' =>'radiolist_elimination'])->label(false) ?>
                </div>
                <div>
                    <label style="padding-left: 20px;" >Number of players per team</label>
                    <div class="item select-show">
                        <select class="basic" name="Tournaments[max_players]" required>
                            <option value="1">One player</option>
                            <option value="2">Two players</option>
                            <option value="4">Four players</option>
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
                        'placeholder' => 'Select operating time ...',
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
                         <div class="col-md-4" style="margin-bottom: 15px;">
                            <button style="width: 100%;"  id="stream_add"  class="btn btn-primary">Add new stream</button> 
                        </div>
                    </div>
                    <div id="conteiner_stream">
                    </div>
                </div>


            </div>
         </div>   
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary formbtn']) ?>
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
            <input type="text" name="stream_url[]" placeholder="Enter stream link here" autocomplete="off">
        </div>
        <span class="close_stream">
        </span>          
    </div>   
</div>
