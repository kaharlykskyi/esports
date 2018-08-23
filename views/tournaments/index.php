<?php

    use app\widgets\Alert;
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use yii\helpers\Url;
    use yii\helpers\ArrayHelper;
    use kartik\datetime\DateTimePicker;

    $this->registerCssFile('css/tournament-public.css', ['depends' => ['app\assets\AppAsset']]);
    $this->registerJsFile(\Yii::$app->request->baseUrl . '/js/profile/tournament-public.js',['depends' => 'yii\web\JqueryAsset','position' => yii\web\View::POS_END]);
    $this->title = 'Tournament';
    $this->params['breadcrumbs'][] = $this->title;

?>
<!--CHAMPIONSHIP WRAP BEGIN-->
    <div class="championship-wrap">

        <h1 style="text-align: center;"><?=$model->name?></h1>
        <!--CHAMPIONSHIP NAVIGATION BEGIN -->
        <div class="champ-navigation">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="champ-nav-list">
                            <li class="active"><a href="#participants">participants</a></li>
                            <li><a href="#matches">Matches</a></li>
                            <li><a href="#tournamentgrid">Tournament grid</a></li>
                            <li><a href="#manage_tournament">Manage Tournament</a></li>
                        </ul>       
                    </div>
                </div>
            </div>              
        </div>
        <!--CHAMPIONSHIP NAVIGATION END -->
        <div class="champ-tab-wrap tab-content">

            <!--CHAMPIONSHIP PART WRAP BEGIN -->
            <div class="tab-item part-wrap tab-pane active" id="participants">
               
                <div class="part-list">
                <div class="container">
                    <div class="row"> 
                        <div class="col-md-12" style="margin-bottom: 30px;">
                            <?php if(empty($model->flag)):?>
                                <p style="color:red;" >To invite teams/player first setup your main tournament settings</p>
                            <?php else: ?>
                                <a href="#myModal1" class="btn btn-secusses" data-toggle="modal" data-flag ="<?=$model->flag ?>"  data-tournament-id="<?=$model->id?>" >Invite participants</a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <a href="club-stats.html" class="item">
                                <span class="logo"><img src="/images/hockey/team-logo1.png" width="80" height="80" alt="team-logo"></span>
                                <span class="name">Team 1</span>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="club-stats.html" class="item">
                                <span class="logo"><img src="/images/hockey/team-logo2.png" width="80" height="80" alt="team-logo"></span>
                                <span class="name">Team 2</span>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="club-stats.html" class="item">
                                <span class="logo"><img src="/images/hockey/team-logo3.png" width="80" height="80" alt="team-logo"></span>
                                <span class="name">Team 3</span>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="club-stats.html" class="item">
                                <span class="logo"><img src="/images/hockey/team-logo4.png" width="80" height="80" alt="team-logo"></span>
                                <span class="name">Team 4</span>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="club-stats.html" class="item">
                                <span class="logo"><img src="/images/hockey/team-logo5.png" width="80" height="80" alt="team-logo"></span>
                                <span class="name">Team 5</span>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="club-stats.html" class="item">
                                <span class="logo"><img src="/images/hockey/team-logo1.png" width="80" height="80" alt="team-logo"></span>
                                <span class="name">Team 6</span>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="club-stats.html" class="item">
                                <span class="logo"><img src="/images/hockey/team-logo2.png" width="80" height="80" alt="team-logo"></span>
                                <span class="name">Team 7</span>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="club-stats.html" class="item">
                                <span class="logo"><img src="/images/hockey/team-logo3.png" width="80" height="80" alt="team-logo"></span>
                                <span class="name">Team 8</span>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="club-stats.html" class="item">
                                <span class="logo"><img src="/images/hockey/team-logo4.png" width="80" height="80" alt="team-logo"></span>
                                <span class="name">Team 9</span>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="club-stats.html" class="item">
                                <span class="logo"><img src="/images/hockey/team-logo5.png" width="80" height="80" alt="team-logo"></span>
                                <span class="name">Team 10</span>
                            </a>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            <!--CHAMPIONSHIP PART WRAP END -->

            <!--CHAMPIONSHIP MATCH WRAP BEGIN -->
            <div class="tab-item match-wrap tab-pane" id="matches">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="main-lates-matches">
                                <a href="matches.html" class="item">
                                    <span class="championship">National cup - quarterfinal</span>
                                    <span class="teams-wrap">
                                        <span class="team"><span><img src="images/hockey/team-logo1.png" alt="team-logo"></span><span>Valencia Valencia</span></span>
                                        <span class="score"><span>3:2</span></span>
                                        <span class="team1"><span>Internacional Internacional</span><span><img src="images/hockey/team-logo2.png" alt="team-logo"></span></span>
                                    </span>
                                    <span class="game-result">(5-4) penalties</span>
                                </a>
                                <a href="matches.html" class="item">
                                    <span class="championship">National cup - quarterfinal</span>
                                    <span class="teams-wrap">
                                        <span class="team"><span><img src="images/hockey/team-logo3.png" alt="team-logo"></span><span>Valencia Valencia</span></span>
                                        <span class="score"><span>3:2</span></span>
                                        <span class="team1"><span>Internacional Internacional</span><span><img src="images/hockey/team-logo4.png" alt=""></span></span>
                                    </span>
                                    <span class="game-result">(5-4) penalties</span>
                                </a>
                                <a href="matches.html" class="item">
                                    <span class="championship">National cup - quarterfinal</span>
                                    <span class="teams-wrap">
                                        <span class="team"><span><img src="images/hockey/team-logo5.png" alt="team-logo"></span><span>Valencia Valencia</span></span>
                                        <span class="score"><span>3:2</span></span>
                                        <span class="team1"><span>Internacional Internacional</span><span><img src="images/hockey/team-logo1.png" alt=""></span></span>
                                    </span>
                                    <span class="game-result">(5-4) penalties</span>
                                </a>
                                <a href="matches.html" class="item">
                                    <span class="championship">National cup - quarterfinal</span>
                                    <span class="teams-wrap">
                                        <span class="team"><span><img src="images/hockey/team-logo1.png" alt="team-logo"></span><span>Valencia Valencia</span></span>
                                        <span class="score"><span>3:2</span></span>
                                        <span class="team1"><span>Internacional Internacional</span><span><img src="images/hockey/team-logo2.png" alt="team-logo"></span></span>
                                    </span>
                                    <span class="game-result">(5-4) penalties</span>
                                </a>
                                <a href="matches.html" class="item">
                                    <span class="championship">National cup - quarterfinal</span>
                                    <span class="teams-wrap">
                                        <span class="team"><span><img src="images/hockey/team-logo3.png" alt="team-logo"></span><span>Valencia Valencia</span></span>
                                        <span class="score"><span>3:2</span></span>
                                        <span class="team1"><span>Internacional Internacional</span><span><img src="images/hockey/team-logo4.png" alt="team-logo"></span></span>
                                    </span>
                                    <span class="game-result">(5-4) penalties</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--CHAMPIONSHIP MATCH WRAP END -->


            <div class="tab-item tournament-tab tab-pane" id="tournamentgrid">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <ul class="tab-filters">
                                <li class="active"><a href="#groupstage" data-toggle="tab">Group stage</a></li>
                                <li><a href="#playoff" data-toggle="tab">Playoffs</a></li>
                            </ul>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 overflow-scroll">
                            <div class="tab-content">
                                <div id="groupstage" class="tab-pane fade in active">
                                    <table class="standing-full">
                                        <tbody>
                                            <tr>
                                                <th>club</th>
                                                <th>played</th>
                                                <th>won</th>
                                                <th>drawn</th>
                                                <th>lost</th>
                                                <th>gd</th>
                                                <th>points</th>
                                                <th>form</th>
                                                <th>next</th>
                                            </tr>
                                            <tr>
                                                <td class="up">
                                                    <i class="fa fa-caret-up" aria-hidden="true"></i> 1 <span class="team"><img src="images/hockey/team-logo1.png" width="30" height="30" alt="team-logo"> </span>Team 1
                                                </td>
                                                <td>11</td>
                                                <td>8</td>
                                                <td>2</td>
                                                <td>1</td>
                                                <td>+16</td>
                                                <td class="points"><span>26</span></td>
                                                <td class="form">
                                                    <span class="win">w</span>
                                                    <span class="drawn">d</span>
                                                    <span class="lose">l</span>
                                                    <span class="win">w</span>
                                                    <span class="win">w</span>
                                                </td>
                                                <td><a href="matches.html"><img src="images/hockey/team-logo2.png" width="30" height="30" alt="team-logo"></a></td>
                                            </tr>
                                            <tr>
                                                <td class="down">
                                                    <i class="fa fa-caret-down" aria-hidden="true"></i> 1 <span class="team"><img src="images/hockey/team-logo2.png" width="30" height="30" alt="team-logo"> </span>Team 2
                                                </td>
                                                <td>11</td>
                                                <td>8</td>
                                                <td>2</td>
                                                <td>1</td>
                                                <td>+16</td>
                                                <td class="points"><span>26</span></td>
                                                <td class="form">
                                                    <span class="win">w</span>
                                                    <span class="drawn">d</span>
                                                    <span class="lose">l</span>
                                                    <span class="win">w</span>
                                                    <span class="lose">l</span>
                                                </td>
                                                <td><a href="matches.html"><img src="images/hockey/team-logo1.png" width="30" height="30" alt="team-logo"></a></td>
                                            </tr>
                                            <tr>
                                                <td class="down">
                                                    <i class="fa fa-caret-down" aria-hidden="true"></i> 1 <span class="team"><img src="images/hockey/team-logo3.png" width="30" height="30" alt="team-logo"> </span>Team 3
                                                </td>
                                                <td>11</td>
                                                <td>8</td>
                                                <td>2</td>
                                                <td>1</td>
                                                <td>+16</td>
                                                <td class="points"><span>26</span></td>
                                                <td class="form">
                                                    <span class="lose">l</span>
                                                    <span class="drawn">d</span>
                                                    <span class="lose">l</span>
                                                    <span class="win">w</span>
                                                    <span class="win">w</span>
                                                </td>
                                                <td><a href="matches.html"><img src="images/hockey/team-logo4.png" width="30" height="30" alt=""></a></td>
                                            </tr>
                                            <tr>
                                                <td class="down">
                                                    <i class="fa fa-caret-down" aria-hidden="true"></i> 1 <span class="team"><img src="images/hockey/team-logo4.png" width="30" height="30" alt="team-logo"> </span>Team 4
                                                </td>
                                                <td>11</td>
                                                <td>8</td>
                                                <td>2</td>
                                                <td>1</td>
                                                <td>+16</td>
                                                <td class="points"><span>26</span></td>
                                                <td class="form">
                                                    <span class="win">w</span>
                                                    <span class="drawn">d</span>
                                                    <span class="lose">l</span>
                                                    <span class="win">w</span>
                                                    <span class="lose">l</span>
                                                </td>
                                                <td><a href="matches.html"><img src="images/hockey/team-logo3.png" width="30" height="30" alt="team-logo"></a></td>
                                            </tr>
                                            <tr>
                                                <td class="none">
                                                    <i class="fa fa-circle" aria-hidden="true"></i> 1 <span class="team"><img src="images/hockey/team-logo5.png" width="30" height="30" alt="team-logo"> </span>Team 5
                                                </td>
                                                <td>11</td>
                                                <td>8</td>
                                                <td>2</td>
                                                <td>1</td>
                                                <td>+16</td>
                                                <td class="points"><span>26</span></td>
                                                <td class="form">
                                                    <span class="win">w</span>
                                                    <span class="drawn">d</span>
                                                    <span class="lose">l</span>
                                                    <span class="win">w</span>
                                                    <span class="win">w</span>
                                                </td>
                                                <td><a href="matches.html"><img src="images/hockey/team-logo1.png" width="30" height="30" alt="team-logo"></a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
    
                                <div id="playoff" class="tab-pane fade">
                                    <table class="standing-full">
                                        <tbody>
                                            <tr>
                                                <th>club</th>
                                                <th>played</th>
                                                <th>won</th>
                                                <th>drawn</th>
                                                <th>lost</th>
                                                <th>gd</th>
                                                <th>points</th>
                                                <th>form</th>
                                                <th>next</th>
                                            </tr>
                                            <tr>
                                                <td class="up">
                                                    <i class="fa fa-caret-up" aria-hidden="true"></i> 1 <span class="team"><img src="images/hockey/team-logo1.png" width="30" height="30" alt="team-logo"> </span>Team 5
                                                </td>
                                                <td>11</td>
                                                <td>8</td>
                                                <td>2</td>
                                                <td>1</td>
                                                <td>+16</td>
                                                <td class="points"><span>26</span></td>
                                                <td class="form">
                                                    <span class="win">w</span>
                                                    <span class="drawn">d</span>
                                                    <span class="lose">l</span>
                                                    <span class="win">w</span>
                                                    <span class="win">w</span>
                                                </td>
                                                <td><a href="matches.html"><img src="images/hockey/team-logo2.png" width="30" height="30" alt="team-logo"></a></td>
                                            </tr>
                                            <tr>
                                                <td class="down">
                                                    <i class="fa fa-caret-down" aria-hidden="true"></i> 1 <span class="team"><img src="images/hockey/team-logo2.png" width="30" height="30" alt="team-logo"> </span>Team 3
                                                </td>
                                                <td>11</td>
                                                <td>8</td>
                                                <td>2</td>
                                                <td>1</td>
                                                <td>+16</td>
                                                <td class="points"><span>26</span></td>
                                                <td class="form">
                                                    <span class="win">w</span>
                                                    <span class="drawn">d</span>
                                                    <span class="lose">l</span>
                                                    <span class="win">w</span>
                                                    <span class="lose">l</span>
                                                </td>
                                                <td><a href="matches.html"><img src="images/hockey/team-logo1.png" width="30" height="30" alt="team-logo"></a></td>
                                            </tr>
                                            <tr>
                                                <td class="down">
                                                    <i class="fa fa-caret-down" aria-hidden="true"></i> 1 <span class="team"><img src="images/hockey/team-logo3.png" width="30" height="30" alt="team-logo"> </span>Team 4
                                                </td>
                                                <td>11</td>
                                                <td>8</td>
                                                <td>2</td>
                                                <td>1</td>
                                                <td>+16</td>
                                                <td class="points"><span>26</span></td>
                                                <td class="form">
                                                    <span class="lose">l</span>
                                                    <span class="drawn">d</span>
                                                    <span class="lose">l</span>
                                                    <span class="win">w</span>
                                                    <span class="win">w</span>
                                                </td>
                                                <td><a href="matches.html"><img src="images/hockey/team-logo4.png" width="30" height="30" alt=""></a></td>
                                            </tr>
                                            <tr>
                                                <td class="down">
                                                    <i class="fa fa-caret-down" aria-hidden="true"></i> 1 <span class="team"><img src="images/hockey/team-logo4.png" width="30" height="30" alt="team-logo"> </span>Team 2
                                                </td>
                                                <td>11</td>
                                                <td>8</td>
                                                <td>2</td>
                                                <td>1</td>
                                                <td>+16</td>
                                                <td class="points"><span>26</span></td>
                                                <td class="form">
                                                    <span class="win">w</span>
                                                    <span class="drawn">d</span>
                                                    <span class="lose">l</span>
                                                    <span class="win">w</span>
                                                    <span class="lose">l</span>
                                                </td>
                                                <td><a href="matches.html"><img src="images/hockey/team-logo3.png" width="30" height="30" alt="team-logo"></a></td>
                                            </tr>
                                            <tr>
                                                <td class="none">
                                                    <i class="fa fa-circle" aria-hidden="true"></i> 1 <span class="team"><img src="images/hockey/team-logo5.png" width="30" height="30" alt="team-logo"> </span>Team 1
                                                </td>
                                                <td>11</td>
                                                <td>8</td>
                                                <td>2</td>
                                                <td>1</td>
                                                <td>+16</td>
                                                <td class="points"><span>26</span></td>
                                                <td class="form">
                                                    <span class="win">w</span>
                                                    <span class="drawn">d</span>
                                                    <span class="lose">l</span>
                                                    <span class="win">w</span>
                                                    <span class="win">w</span>
                                                </td>
                                                <td><a href="matches.html"><img src="images/hockey/team-logo1.png" width="30" height="30" alt="team-logo"></a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!--CHAMPIONSHIP manage_tournament TAB BEGIN -->
            <div class="tab-item news-tab tab-pane" id="manage_tournament">

                    <div class="container">
                        <div class="row">
                            <div class="col-md-7">
                                <ul class="tab-filters">
                                    <li class="active"><a href="#games_settings">Game settings</a></li>
                                    <li><a href="#main">Main</a></li>
                                </ul>
                            </div>
                            
                        </div>
                        <div class="tab-content">
                            <div id="games_settings" class="tab-pane fade in active">
                                <div class="col-md-8 col-md-offset-2" style="margin-bottom: 40px;" >
                                    <?php $form = ActiveForm::begin([ 
                                            'validateOnBlur'=>false,  
                                            'options' => ['enctype' => 'multipart/form-data'],
                                            'fieldConfig' => [
                                                'template' => '{label}{hint}{input}{error}',
                                                'labelOptions' => ['class' => 'col-sm-12 control-label'],
                                            ],
                                        ]); 
                                        $form->errorCssClass = false;
                                        $form->successCssClass = false;
                                    ?>
                                    <div class="row">
                                        <h4 style="text-align: center;"  >UPDATE TOURNAMENT</h4>
                                        <div class="alert_tour col-md-12" style="margin: 20px 0;font-size: 16px;" > <?=Alert::widget()?></div>
                                        
                                        
                                        <div class="col-md-12">
                                            <?= $form->field($model,'flag')->radioList([1 => 'Only players', 2 => 'Only teams', 3 => 'Mixed'],['class' =>'radiolist_only'])->label('Format') ?>
                                        </div>
                                        <div class="col-md-12">
                                            <?= $form->field($model, 'time_limit')
                                            ->textInput(['type' => 'number','class' => 'input_numeric','min' => '15','step' => '5', 'value'=>$model->time_limit])->label('Time limit')?>
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <label class="col-sm-12 control-label" for="teams-background">Region</label>
                                            <div class="item select-show">
                                                <div class="fancy-select ">
                                                    <select class="basic" name="Tournaments[region]" required>
                                                        <option  value="Europe" <?=$model->region == 'Europe' ? 'selected' : '' ?> >Europe</option> 
                                                        <option  value="America" <?=$model->region == 'America' ? 'selected' : '' ?> >America</option>
                                                        <option  value="Asia" <?=$model->region == 'Asia' ? 'selected' : '' ?> >Asia</option>
                                                    </select>
                                                </div>    
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="margin-top: 5px;">
                                            <?=$model->generateForm()?>
                                        </div>

                                    </div>   
                                    <div class="row">


                                        <div class="col-md-12">
                                            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary formbtn']) ?>
                                        </div>
                                    </div>
                                    <?php ActiveForm::end(); ?>
                                </div>  
                            </div>
                            <div id="main" class="tab-pane fade in">
                                                                <div class="col-md-8 col-md-offset-2" style="margin-bottom: 40px;" >
                                    <?php $form = ActiveForm::begin([ 
                                            'validateOnBlur'=>false,  
                                            'options' => ['enctype' => 'multipart/form-data'],
                                            'fieldConfig' => [
                                                'template' => '{label}{hint}{input}{error}',
                                                'labelOptions' => ['class' => 'col-sm-12 control-label'],
                                            ],
                                        ]); 
                                        $form->errorCssClass = false;
                                        $form->successCssClass = false;
                                    ?>
                                    <div class="row">
                                        <h4 style="text-align: center;"  >UPDATE TOURNAMENT</h4>
                                        <div class="alert_tour col-md-12" style="margin: 20px 0;font-size: 16px;" > <?=Alert::widget()?></div>
                                        
                                        <div class="col-md-12">
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
                                                    'startDate' => '01-Mar-2018 12:00 AM',
                                                    'todayHighlight' => true
                                            ]]); ?>

                                        </div>
                                        
                                    </div>   
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary formbtn']) ?>
                                        </div>
                                    </div>
                                    <?php ActiveForm::end(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <!--CHAMPIONSHIP manage_tournament TAB END -->
            
        </div>
    </div>
    <!--CHAMPIONSHIP WRAP END-->
    <div id="myModal1" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                                    
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-9">
                            <input type="text" class="modal_search" placeholder="Search for players" >
                        </div>
                        <div class="col-xs-3">
                            <button class="btn search_btn" id="search_mod">Search</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 " id='content_modal'>
                                               
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>