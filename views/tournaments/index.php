<?php
    
    use app\widgets\Alert;
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use yii\helpers\Url;
    use yii\helpers\ArrayHelper;
    use kartik\datetime\DateTimePicker;
    use app\widgets\Schedule;
    use app\models\Tournaments;
    use app\widgets\ParticipantsData;
    
    
    $this->registerCssFile(\Yii::$app->request->baseUrl .'/dropify/dist/css/dropify.css');
    $this->registerCssFile('css/tournament-public.css', ['depends' => ['app\assets\AppAsset']]);
    $this->registerJsFile(\Yii::$app->request->baseUrl . '/js/profile/tournament-public.js',[
        'depends' => 'yii\web\JqueryAsset',
        'position' => yii\web\View::POS_END
    ]);
    $this->title = 'Tournament';
    $var_data = 'false';
    if ($model->game_id == 3) {
       $var_data = $model->data;
    }
    $default_logo = $model->banner??false;

    $script = "$('.dropify').dropify({
        defaultFile:'{$default_logo}',
        messages: {
            default: \"".Yii::t('app','Drag and drop a file here or click')."\",
            replace: \"".Yii::t('app','Drag and drop or click to replace')."\",
            remove:  \"".Yii::t('app','Remove')."\",
            error:   \"".Yii::t('app','Ooops, something wrong happended.')."\"
        }
    }); $.wowData ={$var_data};$.ratingData={$model->user->ratingOwervatch()};";

    $this->registerJs($script, yii\web\View::POS_END);
    $access = false;

    if (is_object(Yii::$app->user->identity)) {
        if ($model->user_id == Yii::$app->user->identity->id) {
            $access = 1;
        } elseif ($model->isCapitanTeam(Yii::$app->user->identity->id)) {
            $access = 2;
        } elseif ($model->isPlayerTeam(Yii::$app->user->identity->id)) {
            $access = 3;
        }
    } 
?>
    <!--CHAMPIONSHIP WRAP BEGIN-->
    <div class="championship-wrap">
        <h1 style="text-align: center;"><?=$model->name?>  <br>
            <span class="cups_text" ><?=$model->cups[0]?></span>
            <span class="cups_images" ><?=$model->cups[1]?></span>
        </h1>
        <!--CHAMPIONSHIP NAVIGATION BEGIN -->
        <div class="champ-navigation">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="champ-nav-list">
                            <li class="active">
                                <a href="#participants">
                                    <?= Yii::t('app','participants') ?>
                                </a>
                            </li>
                            <?php if ($access): ?>
                                <li >
                                    <a href="#participants_data">
                                        <?= Yii::t('app','Partisipation data') ?>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <li>
                                <a href="#matches"><?= Yii::t('app','Matches') ?></a>
                            </li>
                            <li>
                                <a href="#tournamentgrid" class="tournamentgrid" >
                                    <?= Yii::t('app','Tournament grid') ?>
                                </a>
                            </li>
                            <?php if(($access==1)&&is_null($model->state)&&(empty($players))):?>
                                <li>
                                    <a href="#manage_tournament">
                                        <?= Yii::t('app','Manage Tournament') ?>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if(is_object(Yii::$app->user->identity)): ?>
                                <?php if( in_array(['id' => Yii::$app->user->identity->id],$users_id)&&!empty($model->state)): ?>
                                    <span><a href="/forum/<?=$model->id?>">
                                        <?= Yii::t('app','Tournament thread') ?></a>
                                    </span>
                                <?php endif; ?>
                            <?php endif; ?>
                            <li><a href="#info"><?= Yii::t('app','Tournament info') ?></a></li>
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
                            <?php if(empty($model->cup) && empty($model->league)): ?>
                                <?php if($access==1):?>
                                    <?php if(empty($model->flag)):?>
                                        <p style="color:red;" >
                                            <?= Yii::t('app','To invite teams/player first setup your main tournament settings') ?>
                                        </p>
                                    <?php else: ?>
                                        <a href="#myModal1" class="btn btn-secusses btn_mobil" data-toggle="modal" data-flag ="<?=$model->flag ?>"  data-tournament-id="<?=$model->id?>" >
                                            <?= Yii::t('app','Invite participants') ?>
                                        </a>
                                    <?php endif; ?>
                                <?php endif; ?>
                             <?php endif; ?>   
                        </div>
                    </div>
                    <div class="row">
                        <?php foreach ($players as $player): ?>
                            <div class="col-md-3">
                                <a href="<?= $player->links() ?>" class="item">
                                    <span class="logo">
                                        <img src="<?= $player->logo() ?>" width="80" height="80" alt="team-logo">
                                    </span>
                                    <span class="name"><?=$player->name()?></span>
                                </a>
                            </div>
                        <?php endforeach ;?>
                    </div>
                </div>
                </div>
            </div>
            <!--CHAMPIONSHIP PART WRAP END -->
            <?php if ($access): ?>
                <div class="tab-item part-wrap tab-pane" id="participants_data">
                    <?=ParticipantsData::widget(['model' => $model,'access' => $access])?>
                </div>   
            <?php endif; ?>
            <!--CHAMPIONSHIP MATCH WRAP BEGIN -->
            <div class="tab-item match-wrap tab-pane" id="matches">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="main-lates-matches clearfix" style="margin-bottom: 35px;">
                                <!-- <?///Schedule::widget(['turs'=> $model->getScheduleLeagueModel()])?>
                                <?//Schedule::widget(['turs'=> $model->getScheduleCupModel($model->format)])?> -->
                                <?=Schedule::widget(['turs'=> $model->getSchedules()])?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--CHAMPIONSHIP MATCH WRAP END -->
            <div class="tab-item part-wrap tab-pane " id="tournamentgrid">
                <div class="container">        
                    <div class="row">
                        <div class="col-md-12" style="margin-bottom: 35px;">
                            <?php if(($model->format == Tournaments::SWISS) || ($model->format == Tournaments::LEAGUE)) : ?> 
                               <?php if(empty($model->state) && ($access==1)): ?>
                                    <?php if (in_array(count($players),[4,8,16,32,64,128,256,512])): ?>
                                        <a class="btn btn-primary btn_mobil" href="/tournaments/start?id=<?=$model->id?>" 
                                            data-method="post">
                                            Start tournament
                                        </a>
                                    <?php else: ?>
                                        <p style="color:red;">
                                            <?= Yii::t('app','The number of teams in the tournament must be 4,8,16,32') ?>
                                        </p> 
                                    <?php endif; ?>
                               <?php endif; ?>
                            <?php endif; ?>
                           <?php if(($model->format == Tournaments::SINGLE_E) || ($model->format == Tournaments::DUBLE_E)): ?> 
                               <?php if(empty($model->state) && ($access==1)): ?>
                                    <?php if (in_array(count($players),[4,8,16,32,64,128,256,512])): ?>
                                        <form action="/tournaments/add-schedule?id=<?=$model->id?>" method="POST"  >
                                            <?= Html::hiddenInput(\Yii::$app->getRequest()->csrfParam,\Yii::$app->getRequest()->getCsrfToken(),[]);?>
                                             <div  >
                                                <?= Html::submitButton(Yii::t('app','Start tournament'), ['class' => 'btn btn-primary btn_mobil']) ?>
                                             </div>
                                        </form>
                                    <?php else: ?>
                                        <p style="color:red;">
                                            <?= Yii::t('app','The number of teams in the tournament must be 4,8,16,32') ?>
                                        </p> 
                                    <?php endif; ?>
                               <?php endif; ?>
                            <?php endif; ?>
                            <?php if(($model->format == Tournaments::LEAGUE_G)): ?>
                                <div class="col-md-12" >
                                    <?php $count_playoff = count($players) ?>
                                    <?php if(empty($model->state) && ($access==1)): ?>
                                        <?php if($count_playoff >= 4): ?>
                                        <form action="/tournaments/add-league?id=<?=$model->id?>" method="POST"  >
                                            <?= Html::hiddenInput(\Yii::$app->getRequest()->csrfParam,\Yii::$app->getRequest()->getCsrfToken(),[]);?>
                                             <div  >
                                                <?= Html::submitButton(Yii::t('app','Start tournament'), ['class' => 'btn btn-primary btn_mobil']) ?>
                                             </div>
                                        </form>
                                        <?php else: ?>
                                            <p style="font-size: 18px;font-weight: bold;color:red;">
                                                <?= Yii::t('app','In the league there must be at least 4 participants') ?>
                                            </p>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if($model->state):?>
                        <p style="font-size: 13px;" > 
                            Link to tournament results 
                            <b id="link-tournaments" style="color:red;">
                                 <?=Url::to(['/tournaments/results/','id' => $model->id,'full'=>true], true)?>
                            </b>
                            <button class="btn btn-link-buf" >Copy to buffer</button>
                        </p> 
                        <div class="row container_iframes"  > 
                            <div id="container_iframe" data-href='/tournaments/results/<?=$model->id?>'>
                            </div> 
                            <div class="buttons">
                                <span class="glyphicon glyphicon-fullscreen"></span>
                                <span class="glyphicon glyphicon-resize-small"  style="display: none;" ></span>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
            <!--CHAMPIONSHIP manage_tournament TAB BEGIN -->
            <?php if(($access==1)&&is_null($model->state)&&empty($players)):?>
                <div class="tab-item news-tab tab-pane" id="manage_tournament">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-7">
                                    <ul class="tab-filters">
                                        <li class="active">
                                            <a href="#games_settings"><?= Yii::t('app','Game settings') ?></a>
                                        </li>
                                        <li>
                                            <a href="#main" ><?= Yii::t('app','Main') ?></a>
                                        </li>
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
                                            <h4 style="text-align: center;"  ><?= Yii::t('app','UPDATE TOURNAMENT') ?></h4>
                                            <div class="alert_tour col-md-12" style="margin: 20px 0;font-size: 16px;" > 
                                                <?=Alert::widget()?>
                                            </div>
                                            <div class="col-md-12">
                                                <label class="col-sm-12 control-label" >
                                                    <?= Yii::t('app','Format') ?>
                                                </label>
                                                <div class="center-align field-tournaments-flag"> 
                                                    <input type="radio" name="Tournaments[flag]" id="size_1" value="1" <?= $model->flag==1 ? 'checked' : ''?> />
                                                    <label for="size_1"><?= Yii::t('app','Only players') ?></label>
                                                      
                                                    <input type="radio" name="Tournaments[flag]" id="size_2" value="2" <?= $model->flag==2 ? 'checked' : ''?> />
                                                    <label for="size_2"><?= Yii::t('app','Only teams') ?></label>
                                                    <?php if($model->game_id > 2): ?>
                                                        <input type="radio" name="Tournaments[flag]" id="size_3" value="3" <?= $model->flag==3 ? 'checked' : ''?> />
                                                        <label for="size_3"><?= Yii::t('app','Mixed') ?></label>
                                                    <?php endif; ?>
                                                </div>    
                                            </div>
                                            <div class="col-md-12">
                                                <?= $form->field($model, 'time_limit')
                                                    ->textInput(['type' => 'number','class' => 'input_numeric','min' => '15','step' => '5', 'value'=>$model->time_limit])
                                                    ->label('Time limit')?>
                                            </div>
                                            <div class="col-md-12">
                                                <label class="col-sm-12 control-label" for="teams-background">
                                                    <?= Yii::t('app','Region') ?>
                                                </label>
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
                                            <div class="col-md-12 castom_seting" style="margin-top: 5px;">
                                                <?=$model->generateForm()?>
                                            </div>
                                        </div>   
                                        <div class="row">
                                            <div class="col-md-12">
                                                <?= Html::submitButton(Yii::t('app','Submit'), ['class' => 'btn btn-primary formbtn btn_mobil']) ?>
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
                                            <h4 style="text-align: center;"  ><?= Yii::t('app','UPDATE TOURNAMENT') ?></h4>
                                            <div class="alert_tour col-md-12" style="margin: 20px 0;font-size: 16px;" > 
                                                <?=Alert::widget()?>
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <div  style="margin-bottom:35px;" >
                                                    <label style="padding-left: 20px;" >
                                                        <?= Yii::t('app','Number of players per team') ?>
                                                    </label>
                                                    <div class="item select-show">
                                                        <select class="basic" name="Tournaments[max_players]" required>
                                                            <option value="1" <?=$model->max_players == 1 ? 'selected' : '' ?> >
                                                                <?= Yii::t('app','One player') ?>
                                                            </option>
                                                            <option value="2" <?=$model->max_players == 2 ? 'selected' : '' ?> >
                                                                <?= Yii::t('app','Two players') ?>
                                                            </option>
                                                            <option value="4" <?=$model->max_players == 4 ? 'selected' : '' ?> >
                                                                <?= Yii::t('app','Four players') ?>
                                                            </option>
                                                        </select>
                                                    </div>      
                                                </div>
                                                <?= $form->field($model, 'banner_file')->fileInput(['class' => 'dropify','data-height'=>"200",'data-allowed-file-extensions'=>"jpg png jepg gif"]) ?>
                                                <?= $form->field($model, 'rules')->textarea(['rows' => 12, 'class' => false]) ?>
                                                <?= $form->field($model, 'prizes')->textarea(['rows' => 12, 'class' => false]) ?>
                                                <?= $form->field($model, 'prize_pool')->textInput(['class' => false]) ?>
                                                <?php if(empty($model->cup)&&empty($model->league)): ?>
                                                    <?php if($model->format == Tournaments::LEAGUE_G): ?>
                                                        <div style="margin-bottom:20px;">
                                                            <label class="col-sm-12 control-label" for="teams-background">
                                                                <?= Yii::t('app','Number of teams in the a group') ?>
                                                            </label>
                                                            <div class="item select-show">
                                                                <div class="fancy-select ">
                                                                    <select class="basic" name="Tournaments[league_g]" required>
                                                                        <option  value="2" <?=$model->league_g == 2 ? 'selected' : '' ?> >2</option> 
                                                                        <option  value="4" <?=$model->league_g == 4 ? 'selected' : '' ?> >4</option>
                                                                        <option  value="8" <?=$model->league_g == 8 ? 'selected' : '' ?> >8</option>
                                                                        <option  value="16" <?=$model->league_g == 16 ? 'selected' : '' ?> >16</option>
                                                                    </select>
                                                                </div>    
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if(($model->format == Tournaments::LEAGUE_G)||($model->format == Tournaments::LEAGUE_P)): ?>
                                                        <div style="margin-bottom:20px;">
                                                            <label class="col-sm-12 control-label" for="teams-background">
                                                                <?= Yii::t('app','Number of teams that go into the playoffs') ?>
                                                            </label>
                                                            <div class="item select-show">
                                                                <div class="fancy-select ">
                                                                    <select class="basic" name="Tournaments[league_p]" required>
                                                                        <option  value="2" <?=$model->league_p == 2 ? 'selected' : '' ?> >2</option> 
                                                                        <option  value="4" <?=$model->league_p == 4 ? 'selected' : '' ?> >4</option>
                                                                        <option  value="8" <?=$model->league_p == 8 ? 'selected' : '' ?> >8</option>
                                                                        <option  value="16" <?=$model->league_p == 16 ? 'selected' : '' ?> >16</option>
                                                                    </select>
                                                                </div>    
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                                <?php  
                                                echo $form->field($model, 'start_date')->widget(DateTimePicker::className(),[
                                                    'name' => 'datetime_10',
                                                    'readonly' => true ,
                                                    'removeButton' => false ,
                                                    'options' => [  
                                                        'placeholder' => 'Select operating time ...',
                                                        'autocomplete'=>"off",'class'=>'datainput',
                                                    ],
                                                    'convertFormat' => true,
                                                    'pluginOptions' => [
                                                        'format' => 'yyyy-MM-dd H:i',
                                                        'startDate' => date("Y-m-d H:i"),
                                                        'todayHighlight' => true
                                                ]]); ?>
                                            </div>
                                        </div>   
                                        <div class="row">
                                            <div class="col-md-12">
                                                <?= Html::submitButton( Yii::t('app','Submit'), ['class' => 'btn btn-primary formbtn btn_mobil']) ?>
                                            </div>
                                        </div>
                                        <?php ActiveForm::end(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            <?php endif; ?>
            <!--CHAMPIONSHIP manage_tournament TAB END --> 
            <div class="tab-item part-wrap tab-pane" id="info">
                <h3  style="text-align: center;" ><?=Yii::t('app','tournament information')?></h3>
                <div class="container" style="margin-bottom: 40px;">
                    <div class="row">
                        <div class="col-md-4 col-md-offset-2"><b>Game:</b></div>
                        <div class="col-md-6"><?=$model->game->name?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-md-offset-2 "><b>Format tournament:</b></div>
                        <div class="col-md-6">
                            <span>
                            <?php
                            switch ($model->format) {
                                case 1:
                                echo Yii::t('app','Cup (Single elimination)');
                                break;
                                case 2:
                                echo Yii::t('app','Cup (Duble elimination)');
                                break;
                                case 3:
                                echo Yii::t('app','League (Regular)');
                                break;
                                case 4:
                                echo Yii::t('app','League (Regular + Playoff)');
                                break;
                                case 5:
                                echo Yii::t('app','League (Group + Playoff)');
                                case 6:
                                echo Yii::t('app','Swiss system');
                                break;           
                            }
                            ?>
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-md-offset-2">
                            <b><?=Yii::t('app','Rules of the tournament')?>:</b>
                        </div>
                        <div class="col-md-6"><?=$model->rules?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-md-offset-2"><b><?=Yii::t('app','Tournament prizes')?>:</b></div>
                        <div class="col-md-6"><?=$model->prizes?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-md-offset-2"><b><?=Yii::t('app','Prize pool')?> $:</b></div>
                        <div class="col-md-6"><?=$model->prize_pool?></div>
                    </div>

                    <?php 
                        $t_data = json_decode($model->data,true);
                        $g_data = json_decode($model->game->filed,true);
                        $g_data = ArrayHelper::index($g_data, 'name');
                    ?>
                    <?php if(is_array($t_data)): ?>
                    <?php foreach($t_data as $key => $val): ?>
                        <?php if(!empty($g_data[$key])): ?>
                            <div class="row">
                                <div class="col-md-4 col-md-offset-2">
                                    <b><?=$g_data[$key]['title']?>:</b>
                                </div>
                                <div class="col-md-6">
                                <?php if ($g_data[$key]['type'] == 'checkbox') {
                                        if (!(int)$val) {
                                            echo 'No';
                                        } else {
                                            echo 'Yes';
                                        }
                                    } elseif (is_array($val)) {
                                        if (empty($val[0])) {
                                            echo 'No';
                                        } else {
                                            echo 'Yes';
                                        }
                                    } else {
                                        echo $val;
                                }?>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="row">
                                <div class="col-md-4 col-md-offset-2"><b>
                                    <?=mb_convert_case(str_replace('_','',$key),MB_CASE_TITLE)?>:</b>
                                </div>
                                <div class="col-md-6">
                                    <?php 
                                        if (is_array($val)) {
                                            foreach ($val as $val_data) {
                                               echo '\''.$val_data.'\'&nbsp;&nbsp;&nbsp;';
                                            }
                                        } else {
                                            echo $val.' ';
                                        }
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                   <?php endif; ?>
                </div>
            </div>  
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
                        <div class="col-md-9 col-sm-9 col-xs-7">
                            <input type="text" class="modal_search search_mobil" placeholder="Search for players" >
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-5">
                            <button class="btn search_btn btn_mobil" id="search_mod"><?=Yii::t('app','Search')?></button>
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


    