<?php
    use app\widgets\Alert;
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use yii\helpers\Url;
    use kartik\datetime\DateTimePicker;

    $this->registerCssFile('css/profile.css', ['depends' => ['app\assets\AppAsset']]);
    $this->registerCssFile(\Yii::$app->request->baseUrl .'/dropify/dist/css/dropify.css');
    $this->registerJsFile(\Yii::$app->request->baseUrl . '/js/profile/profile.js',['depends' => 'yii\web\JqueryAsset','position' => yii\web\View::POS_END]);
    $this->registerJsFile(\Yii::$app->request->baseUrl . '/js/profile/update-team.js',['depends' => 'yii\web\JqueryAsset','position' => yii\web\View::POS_END]);
    $this->title = 'Profile';
    $this->params['breadcrumbs'][] = $this->title;
    $user = \Yii::$app->user->identity;
    $script = "$('.dropify').dropify({
        defaultFile:'{$user->logo}',
        messages: {
            'default': '".Yii::t('app','Drag and drop a file here or click')."',
            'replace': '".Yii::t('app','Drag and drop or click to replace')."',
            'remove':  '".Yii::t('app','Remove')."',
            'error':   '".Yii::t('app','Ooops, something wrong happended.')."'
        }
    });

    $('.dropify1').dropify({
        defaultFile:'{$user->background}',
        messages: {
            'default': '".Yii::t('app','Drag and drop a file here or click')."',
            'replace': '".Yii::t('app','Drag and drop or click to replace')."',
            'remove':  '".Yii::t('app','Remove')."',
            'error':   '".Yii::t('app','Ooops, something wrong happended.')."'
        }
    });
    ";

    $this->registerJs($script, yii\web\View::POS_END);
    $teams_m = $user->getMessageTeams();
?>


<section class="image-header img-url" style="margin-bottom:70px;<?=$user->background ? "background-image: url($user->background);" :''?>">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="info">
                    <div class="wrap clearfix">
                        <div class="info_user">
                            <div class="youplay-user"> 
                                <a href="/user/public/<?=$user->id?>" class="angled-img">
                                    <div class="img"> 
                                        <img src="<?=$user->avatar()?>" class="avatar user-1-avatar avatar-200 photo" width="200" height="200" alt="Profile picture of nK">
                                    </div> 
                                </a>
                                <div class="user-data">
                                    <h2 class="user-data-h2">
                                        <?= $user->name ?>
                                    </h2> @<?= $user->username ?>
                                    <div class="youplay-user-activity"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
            
        </div>
    </div>
    <div class="youplay-user-navigation">
        <div class="container">
            <ul class="flickity-enabled is-draggable nav nav-tabs" tabindex="0">
                <li id="activity-personal-li" class="current selected active is-selected" aria-selected="true" >
                    <a id="user-activity" data-toggle="tab" href="#profile">
                        <?=Yii::t('app','Profile')?>
                    </a>
                </li>
                <li id="xprofile-personal-li" aria-selected="false" >
                    <a id="user-xprofile" data-toggle="tab" href="#activity">
                        <?=Yii::t('app','Activity')?>
                    </a>
                </li>
                <li id="blogs-personal-li" aria-selected="false" >
                    <a id="user-blogs" data-toggle="tab" href="#teams">
                        <?=Yii::t('app','My teams')?> 
                        <span class="badge mnb-1"><?=$teams['count_teams']?></span></a>
                </li>
                <li id="seting-personal-li" aria-selected="false" >
                    <a id="user-seting" data-toggle="tab" href="#tournaments">
                        <?=Yii::t('app','My tournaments')?> 
                        <span class="badge mnb-1">
                            <?=count($tournaments)?>
                        </span>
                    </a>
                </li>  
                <li id="friends-personal-li" aria-selected="false" >
                    <a id="user-friends" data-toggle="tab" href="#panel4">
                        <?=Yii::t('app','Friends')?>
                        <span class="badge mnb-1 sr-only">0</span>
                    </a>
                </li> 
                <li id="seting-personal-li" aria-selected="false" >
                    <a id="user-seting" data-toggle="tab" href="#settings">
                        <?=Yii::t('app','Settings')?>
                        <span class="badge mnb-1 sr-only">0</span>
                    </a>
                </li> 
            </ul>
        </div>
    </div>
</section>
<div class="container"  >
    <?=Alert::widget()?>
    <?php if ($user->isBaned()): ?>
        <div class="alert-danger alert" style="margin-top: 25px;">
            You are banned to <?=$user->ban_date?>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-md-9 ">
            <div class="tab-content my-tabs">
                <div id="profile" class="tab-pane fade in active">
                    <div class="col-md-12">
                        <h4><?=Yii::t('app','Base')?></h4>
                        <table class="table table-profile" >
                            <tbody>
                                <tr>
                                    <td ><?=Yii::t('app','Name')?></td>
                                    <td><?= $user->name ?></td>
                                </tr>
                                <tr>
                                    <td><?=Yii::t('app','Sex') ?></td>
                                    <td>
                                        <?php if ($user->sex) :?>
                                            <?=$user->sex == 1 ? Yii::t('app','Male'): ($user->sex == 2 ?Yii::t('app','Female'): '----') ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?=Yii::t('app','Birthday') ?></td>
                                    <td><?= $user->birthday ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12">
                        <h4><?=Yii::t('app','Interests')?></h4>
                        <table class="table table-profile">
                            <tbody>
                                <tr>
                                    <td ><?=Yii::t('app','Activities')?></td>
                                    <td ><?= $user->activities ?></td>
                                </tr>
                                <tr>
                                    <td><?=Yii::t('app','Interests')?></td>
                                    <td ><?=$user->interests ?></td>
                                </tr>
                                <tr>
                                    <td><?=Yii::t('app','Favorite game')?></td>
                                    <td>
                                        <?php if ($user->gameF):?>
                                            <img  style="height: 25px;" src="/images/game/<?=$user->gameF->logo;?>" alt="<?=$user->gameF->name;?>">  &#160;&#160;
                                            <?=$user->gameF->name;?>
                                        <?php endif; ?>
                                    </td>
                                </tr>        
                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="activity" class="tab-pane fade">
                    <div class="row">
                        <div class="col-md-7">
                            <ul class="tab-filters">
                                <li class="active" >
                                    <a href="#notifications">
                                        <?=Yii::t('app','Notifications')?>
                                    </a>
                                </li>
                                <li>
                                    <a href="#matches"><?=Yii::t('app','Matches')?></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div id="notifications" class="tab-pane fade in active">
                            <div class="wrap-lists"> 
                                <?php foreach($teams_m as $team) : ?>  
                                    <div class="lists">
                                        <div class="youplay-timeline-icon "> 
                                            <a href="<?=$team->links()?>">
                                                <img src="<?=$team['logo']?>" class="avatar user-1-avatar avatar-80 photo" width="80" height="80" alt="Team logo"> 
                                            </a>
                                        </div>

                                        <div class="wrap">     
                                            <h3 class="activity-header">
                                                <p>
                                                    <?=Yii::t('app','The')?> <a href="<?=$team->links()?>">
                                                        <?=$team['name']?>
                                                    </a> <?=Yii::t('app','team invites you to become part of its players.')?>
                                                </p>
                                            </h3>
                                            <div class="clearfix"></div>
                                            <div class="activity-inner">
                                                <p>
                                                    <?=Yii::t('app','To accept or decline the invitation click the link below:')?></br>
                                                    <a href="<?= Url::to(['profile/confirmation-team','confirmation_tokin' => $team['status_tokin']], true)?>" >
                                                     <?= Url::to(['profile/confirmation-team','confirmation_tokin' => $team['status_tokin']], true)?>
                                                    </a></br>
                                                    <?=Yii::t('app','Finally, if you want more information, contact')?> 
                                                    <?=$team['name']?> 
                                                    <?=Yii::t('app','through their website, or through their captain, by email ')?>
                                                     
                                                    <a href="<?= $team['u_email']?>">
                                                        <?= $team['u_email']?>
                                                    </a>.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                <?php foreach($user->messages as $message) : ?>
                                    
                                    <div class="lists">
                                        <!-- <div class="closes" data-delete="<?//$message->id?>" ></div> -->
                                        <div class="youplay-timeline-icon "> 
                                            <a href="/user/public/<?=$message->senders->id?>">
                                                <img src="<?=$message->senders->avatar()?>" class="avatar user-1-avatar avatar-80 photo" width="80" height="80" alt="Team logo"> 
                                            </a>
                                        </div>

                                        <div class="wrap">     
                                            <h3 class="activity-header">
                                                <p>
                                                    <?=$message->title?>
                                                    <p class="view youplay-timeline-date pt-5 bp-tooltip"  style="color: ">
                                                        <span class="time-since" style="color: #1976d2;" >
                                                            created <?=  date(' d \of F, Y ',$message->created_at) ?>
                                                        </span>
                                                    </p>
                                                </p>
                                            </h3>
                                            <div class="activity-inner">
                                                <div>
                                                    <?=$message->text?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div id="matches" class="tab-pane fade in">
                            <?php foreach ($tournaments as $tournament): ?>
                                <?php if($tournament->user_id == $user->id): ?>
                                <?php $matches = $tournament->getMatchesResult(); ?>
                                <?php foreach ($matches as $match): ?>
                                    <div class="lists" style="margin-bottom: 25px;">   
                                        <h3 class="activity-header">
                                                <p>
                                                    <?=Yii::t('app','match between teams')?> 
                                                <a href="<?=$match->teamS->links()?>"><?=$match->teamS->name?></a>
                                                    <?=Yii::t('app','and')?>
                                                <a href="<?=$match->teamF->links()?>"><?=$match->teamF->name?></a> 
                                                <p class="view youplay-timeline-date pt-5 bp-tooltip"  style="color: ">
                                                    <span class="time-since" style="color: #1976d2;" >
                                                    <?=Yii::t('app','date of the match')?> 
                                                    <?=date(' d \of F, Y ',strtotime($match->date)) ?>
                                                    </span>
                                                </p>
                                            </p>
                                        </h3>
                                        <div class="activity-inner">
                                            <div>
                                                <?=Yii::t('app','To set the match results follow the link')?> 
                                                <a href="/matches/public/<?=$match->id?>">
                                                    /matches/public/<?=$match->id?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div id="teams" class="tab-pane fade">
                    <div class="row">
                        <div class="col-md-7" style="margin-bottom: 25px;" >
                            <?php if (($teams['btn']>0) && !$user->isBaned()): ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <a href="/profile/create-team" class="btn btn-primary">
                                            <?=Yii::t('app','Create a team')?>
                                        </a>
                                        <a href="#myModal2" class="btn btn-primary" data-toggle="modal" >
                                            <?=Yii::t('app','Find the team')?>
                                        </a>
                                    </div>
                                </div>
                            <?php endif;?>
                        </div>
                        <div class="col-md-5" style="margin-bottom:30px;">
                            <div class="row">
                            </div>   
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table" >
                                <tbody>
                                    <?php foreach ($teams['teams'] as $team):?>
                                        <tr>
                                            <td style="width: 130px; vertical-align: middle" >
                                                <div class="img-game">
                                                    <a href="<?=$team->links()?>">
                                                        <img src="<?=$team->logo ?>" class="avatar group-1-avatar avatar-100 photo" width="100" height="100" alt="Team logo">
                                                    </a>
                                                </div>
                                            </td>
                                            <td style="vertical-align: middle; padding-left: 20px;">
                                                <div class="item-title">
                                                    <a href="<?=$team->links()?>"><?=$team->name?></a>
                                                </div>
                                                <div class="item-meta">
                                                    <span class="date">
                                                        <?=Yii::t('app','Created')?> 
                                                        <?= date("d-m-Y",$team->created_at) ?>
                                                    </span>
                                                </div>
                                                <div class="item-desc">
                                                    <p><?= $team->game->name ?></p>
                                                </div>
                                                <div class="members-small">
                                                    <p> 
                                                        <?= $team->coutUsers() ?>
                                                        <?=Yii::t('app','member(s)')?> 
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="text-right" style="vertical-align: middle">
                                                <div class="meta">
                                                    <?php if($team->capitan == $user->id ): ?>
                                                    <a class="btn edit-team" href="#myModal1" data-toggle="modal" data-game-id="<?=$team->id ?>">
                                                        <?=Yii::t('app','Add new members')?>
                                                    </a>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="meta">
                                                    <?php if($team->capitan == $user->id ): ?>
                                                        <a href="/profile/update-team?id=<?=$team->id?>" class="btn edit-team edit-btn">
                                                            <?=Yii::t('app','Edit team')?>
                                                        </a>
                                                    <?php else: ?>
                                                        <a href="/profile/exit-team?id=<?=$team->id?>" class="btn edit-team btn-red">
                                                            <?=Yii::t('app','Leave the team')?>
                                                        </a>   
                                                    <?php endif; ?>
                                                </div>
                                                <div class="meta conteiner_btn">
                                                    <?php if($team->capitan == $user->id ): ?>
                                                        <button class="btn edit-team btn-red delete"  data-modeel-id="<?=$team->id?>">
                                                            <?=Yii::t('app','Delete the team')?>
                                                        </button>  
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>

                        <div id="myModal1" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    </div>
                                    
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-xs-9">
                                                <input type="text" class="modal_search" placeholder="
                                                <?=Yii::t('app','Search for players')?>" >
                                            </div>
                                            <div class="col-xs-3">
                                                <button class="btn search_btn" id="search_mod">
                                                    <?=Yii::t('app','Search')?>
                                                </button>
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
                        <div id="myModal2" class="modal fade">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    </div>
                                    
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-xs-8 col-md-9" >
                                                <input type="text" class="modal_search_team" placeholder="
                                                    <?=Yii::t('app','Search by team name')?>" >
                                            </div>
                                            <div class="col-xs-2">
                                                <button class="btn search_btn" id="search_mod_team_btn"><?=Yii::t('app','Search')?></button>
                                            </div>
                                           
                                        </div>
                                        <div class="row filtres_modal" style="margin-top: 20px">
                                            <div class="col-xs-12">
                                                <p><a href="#" class="filter_modal_link" >
                                                    <?=Yii::t('app','Filters')?> <span class="glyphicon glyphicon-filter"></span></a>
                                                </p>
                                            </div>
                                            <div class="filter_modal_content" style="display: none;" >
                                                <div class="col-md-6">
                                                    <p style="text-align: center;" >
                                                         <?=Yii::t('app','By team quality')?>
                                                    </p>
                                                    <div class="item select-show team_quality">
                                                        <select class="basic" name="" id="">
                                                            <option value="0">
                                                                <?=Yii::t('app','Please Select')?> 
                                                            </option>
                                                            <option value="1" >
                                                                <?=Yii::t('app','The team participates in a league or cup')?>
                                                            </option>
                                                            <option value="2" >
                                                                <?=Yii::t('app','The team has participated in a league or cup')?>
                                                            </option>
                                                            <option value="3" >
                                                                <?=Yii::t('app','The team is new and has not participated in a league or a cup')?>
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                <p style="text-align: center;" >
                                                    <?=Yii::t('app','By team game')?>
                                                </p>
                                                 <div class="item select-show team_game">
                                                    <select class="basic" name="" id="">
                                                        <option value="0">
                                                            <?=Yii::t('app','Please Select')?>
                                                        </option>
                                                        <?php foreach ($not_games as $game): ?>
                                                            <option value="<?=$game->id?>" ><?=$game->name?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 " id='content_teams_modal_team'>
                                               
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        </div>
                    </div>
                </div>
                <div id="tournaments" class="tab-pane fade">

                    <div class="row">
                        <?php if (!$user->isBaned()): ?>
                        <div class="col-md-12" style="margin-bottom: 30px;">
                            <a href="/tournaments/create" class="btn btn-primary">
                                <?=Yii::t('app','Create a tournament')?>
                            </a> 
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="row">
                        <?php foreach ($tournaments as $tournament):?>
                            <div class="col-md-12 tournament_list">
                                <div class="col-sm-5">
                                    <p class="name"> <a href="/tournaments/public/<?=$tournament->id?>">
                                        <?=$tournament->name?></a>
                                    </p>
                                    <p><?=Yii::t('app','Participants')?>: 
                                        <span><?=count($tournament->getPlayers())?></span>
                                    </p>
                                    <p><?=Yii::t('app','Game')?>: <span><?=$tournament->game->name?></span></p>
                                    <p>Format:
                                        <span>
                                            <?php
                                                switch ($tournament->format) {
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
                                                        break;           
                                                }
                                            ?>
                                        </span>
                                    </p>
                                </div>
                                <div class="col-sm-7 content_btn">
                                    <p>
                                        <?php if($user->id == $tournament->user_id): ?>
                                        <a class="btn edit-team" href="/tournaments/public/<?=$tournament->id?>#manage_tournament">
                                            <?=Yii::t('app','Manage')?>
                                        </a>
                                    <?php endif; ?>
                                    </p>
                                    <p>
                                        <a class="btn edit-team" href="/tournaments/public/<?=$tournament->id?>">
                                            <?=Yii::t('app','View')?>
                                        </a>
                                    </p>
                                </div>            
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div id="panel4" class="tab-pane fade">
                    <div class="row">
                        <div class="col-md-5 col-md-offset-7" style="margin-bottom:30px;">
                            <div class="row">
                            </div>   
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="members friends">
                                <div id="" class="alert alert-info">
                                    <p class="m-0">Sorry, no members were found.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="settings" class="tab-pane fade">
                    <div class="row">
                        <div class="col-md-12" style="margin-bottom: 40px;" >
                           
                            <?php $form = ActiveForm::begin([
                                    'options' => ['enctype' => 'multipart/form-data'],
                                    'action' =>'/profile/settings',
                                    'fieldConfig' => [
                                        'template' => '{label}{hint}{input}{error}',
                                        'labelOptions' => ['class' => 'col-sm-12 control-label'],
                                    ],
                                ]); 
                                    $form->validateOnBlur = false;
                                    $form->successCssClass = false;
                            ?>   
                                <?= $form->field($user, 'name')->textInput(['class' => false])
                                    ->label(Yii::t('app','First name')) ?>
                                <?=$form->field($user, 'file_logo')->fileInput(['class' => 'dropify','data-height'=>"200",'data-allowed-file-extensions'=>"jpg png jepg gif"])->label(Yii::t('app','Logo')) ?> 
                                <?=$form->field($user, 'file_background')->fileInput(['class' => 'dropify1','data-height'=>"300",'data-allowed-file-extensions'=>"jpg png jepg gif"])->label(Yii::t('app','Background')) ?> 

                                <div style="margin-bottom: 25px;">
                                    <label class="control-label"><?=Yii::t('app','Sex')?></label>
                                    <div class="item select-show">
                                        <div class="fancy-select ">
                                            <select class="basic" name="User[sex]" >
                                                <option value="1" <?=$user->sex == 1 ? 'selected' : '' ?> >
                                                    <?=Yii::t('app','Male')?>
                                                </option>
                                                <option value="2" <?=$user->sex == 2 ? 'selected' : '' ?> >
                                                    <?=Yii::t('app','Female')?>
                                                </option>
                                            </select>
                                        </div>    
                                    </div>
                                </div>

                              
                                <div style="margin-bottom: 80px;">
                                    <label class="control-label" >
                                        <?=Yii::t('app','Favorite game')?>
                                   </label>
                                    <div id="radios" class="clearfix" style="text-align: center;">
                                        <?php $i=0; foreach($games as $value):
                                            $i++;
                                        ?> 
                                            <label for="input<?=$i?>" class='game <?=$user->favorite_game == $value->id ?'actives':'' ?>'  >
                                                    <img class='geme_icon' src="../images/game/<?=$value->logo?>" alt="">
                                            </label>
                                            <input id="input<?=$i?>" name="User[favorite_game]" type="radio" value="<?=$value->id?>">
                                            <?php endforeach; ?>
                                    </div>     
                                </div>
                                

                                <div class="checkbox" style="margin-bottom: 40px;">
                                    <input type="checkbox" name="User[visible]" value='1' uncheckValue='0' class='filter-check' id="check_visible" <?= $user->visible ? 'checked': ''?>>
                                    <label for="check_visible" >
                                        <span style="font-size: 18px;position: relative;bottom: 5px;">
                                            <?=Yii::t('app','I allow to send me invites to the teams')?>
                                        </span>
                                    </label>
                                </div>
                
                                <div style="margin-bottom: 40px;">   
                                    <?= $form->field($user, 'birthday')->widget(DateTimePicker::className(),[

                                    'options' => [  
                                        'placeholder' => 'Select operating time ...',
                                        'autocomplete'=>"off",'class'=>'datainput',
                                    ],
                                    'convertFormat' => true,
                                    'pluginOptions' => [
                                        'format' => 'yyyy-MM-dd hh:i',
                                        //'startDate' => date("Y-m-d H:i"),//'2018-08-22 02:55'
                                        'todayHighlight' => true
                                ]])->label(Yii::t('app','Birthday')) ?>
                                        
                                </div>
                               
                                <div class="item" style="margin-bottom: 25px;">
                                    <label ><?=Yii::t('app','Activities')?></label>
                                    <textarea name="User[activities]" ><?= $user->activities ?></textarea>
                                </div>

                                <div class="item" style="margin-bottom: 25px;">
                                    <label ><?=Yii::t('app','Interests')?></label>
                                    <textarea name="User[interests]" ><?=$user->interests ?></textarea>
                                </div>
                                
                                <button type="submit" class="btn submit-btn" ><?=Yii::t('app','Save')?></button>
                            <?php ActiveForm::end(); ?>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="margin-bottom: 40px;" >
                                <h6 style="text-align: center;" >add a link to your social network</h6>
                            <?php $sociali = ActiveForm::begin([
                                        'options' => ['enctype' => 'multipart/form-data'],
                                        'action' =>'/profile/add-link',
                                        'validateOnBlur'=>false,
                                        'fieldConfig' => [
                                            'template' => '{label}{hint}{input}{error}',
                                            'labelOptions' => ['class' => 'col-sm-12 control-label'],
                                        ],]); ?>
                                
                                    <div class="col-md-5">
                                        <div style="margin-bottom: 25px;">
                                            <label class="control-label"><?=Yii::t('app','Social network')?></label>
                                            <div class="item select-show">
                                                <div class="fancy-select ">
                                                    <select class="basic" name="SocialLinks[social_id]" >
                                                        <option value="1">
                                                            Facebook
                                                        </option>
                                                        <option value="2"  >
                                                            Instagram
                                                        </option>
                                                    </select>
                                                </div>    
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <?=$sociali->field($social_links, 'link')
                                            ->textInput(['class' => false,'type'=>"url"])
                                            ->label('Link'); 
                                        ?>
                                    </div>
                             <div class="col-sm-12"> 
                                <button type="submit" class="btn submit-btn"><?=Yii::t('app','Save Link')?></button>
                            </div>
                            <?php ActiveForm::end(); ?>
                            </div>
                            <div class="col-sm-12" style="margin-bottom: 30px;">
                                <?php $social_links = $user->social_links; ?>
                                <div class="col-sm-8 col-sm-offset-2">
                                <?php foreach($social_links as $link ): ?>
                                    <span>
                                        <form action="/profile/del-link" method="post" >
                                             <?=Html::hiddenInput(\Yii::$app->getRequest()->csrfParam, \Yii::$app->getRequest()->getCsrfToken(), []);?>
                                            <a href="<?=$link->link?>"><?=$link->link?></a>
                                            <input type="hidden" value="<?=$link->id?>" name="link_id">
                                            <button class="fantom-link" title='delete link'>
                                                <span style="color:red;" class="glyphicon glyphicon-remove-circle"></span>
                                            </button>
                                        </form>
                                    </span> 
                                <?php endforeach; ?>
                                </div>
                            </div>   
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
        </div>
    </div>
</div>

