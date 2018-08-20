<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\datetime\DateTimePicker;


$this->title = 'Create tournaments';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile(\Yii::$app->request->baseUrl .'/css/create-team.css');
$this->registerCssFile(\Yii::$app->request->baseUrl .'/css/tournaments.css');
$this->registerJsFile(\Yii::$app->request->baseUrl . '/js/create-team.js',['depends' => 'yii\web\JqueryAsset','position' => yii\web\View::POS_END]);
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
                            <input id="input<?=$i?>" name="Tournaments[game_id]" type="radio" value="<?=$value->id?>">
                        <?php endforeach; ?>
                        </div>
                        <div class="erroe-massage" style="display: none;">To select a game press the logo</div>                    
                     </div>
                </div>

                <div class="row" id="format_campions_elimination" style="margin:25px 0;" >
                   
                    <label class="col-sm-12 control-label" >Tournament format</label>
                    
                    <div class="col-md-10 col-md-offset-1 "  style="margin-top:25px;">
                        <div class="col-md-6 ">
                            <div class="format_campions"  data-farmat ='0' >
                                <div class="container_img" >
                                    <img src="/images/profile/cup.png"  alt="cup">
                                </div>
                                <div style="padding-left: 25px;" ><h5>cup</h5></div>
                            </div>
                        </div>

                        <div class="col-md-6 ">
                            <div class="format_campions" data-farmat='1'>
                                <div class="container_img" style="padding-left: 10px;">
                                    <img src="/images/profile/league.png"  alt="league">
                                </div>
                                <div style="padding-left: 25px;" ><h5>league</h5></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 col-md-offset-1" id="elimination" style="display:none;margin-top:25px;">
                        <div class="col-md-6 ">
                            <div class="format_campions elimination " data-farmat ='2'>
                                <div class="container_img" >
                                    <img src="/images/profile/single_elimination.png"  alt="s_cup">
                                </div>
                                <div style="flex-grow: " ><h5>Single elimination</h5></div>
                            </div>
                        </div>

                        <div class="col-md-6 ">
                            <div class="format_campions elimination" data-farmat ='3'>
                                <div class="container_img" >
                                    <img src="/images/profile/duble_elimination.png"  alt="d_cup">
                                </div>
                                <div><h5>Double elimination</h5></div>
                            </div>
                        </div>
                    </div>
                    
                    
                </div>
                <div ><!-- style="display: none; -->
                    <?= $form->field($model, 'format')->radioList([1 => 'a', 2 => 'b', 3 => 'c'],['class' =>'radiolist_elimination'])->label(false) ?>
                </div>
                  
                <?= $form->field($model, 'rules')->textarea(['rows' => 12, 'class' => false]) ?>
                <?= $form->field($model, 'prizes')->textarea(['rows' => 12, 'class' => false]) ?>
               

                <?php  
                echo $form->field($model, 'start_date')->widget(DateTimePicker::className(),[
                    'name' => 'datetime_10',
                    'options' => [  
                        'placeholder' => 'Select operating time ...',
                        'autocomplete'=>"off",'class'=>'datainput',
                    ],
                    'convertFormat' => true,
                    'pluginOptions' => [
                        'format' => 'yyyy-MM-dd hh:i',
                        'startDate' => '01-Mar-2014 12:00 AM',
                        'todayHighlight' => true
                ]]); ?>

        



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
