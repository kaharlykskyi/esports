<?php
    use app\widgets\Alert;
    use yii\helpers\Html;
    use app\models\servises\FlagServis;
    use Yii;
    $this->registerCssFile('https://use.fontawesome.com/releases/v5.2.0/css/all.css');
    $this->registerCssFile('css/team.css', ['depends' => ['app\assets\AppAsset']]);
    $this->title = Yii::t('app','Team');
    $matches = $team->matces;
?>

<section class="image-header" style="min-height: 450px; background: url(<?=$team->background?>) no-repeat right;background-size: cover;">
    <div class="player-photo geme-foto">
        <img class="img-responsive" src="/images/game/<?=$team->game->logo?>" alt="logo">
    </div>
    <div class="player-photo geme-foto" style="top:300px;">
        <img class="img-responsive" src="<?=FlagServis::getLinkFlag($team->capitans->country);?>" alt="flag">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="info">
                    <div class="wrap">
                    </div>
                </div>
            </div>  
        </div>
    </div>
</section>

<!-- end image-header -->
  
<div class="club-staff-top">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center"><?=$team->name?></h2>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h4 class="edgtf-st-title" ><?=Yii::t('app','STATISTICS')?></h4>
                <div class="row statistic_icons">
                    <div class="col-md-3 block_icon">
                        <i class="fa fa-star" aria-hidden="true"></i> 
                        <span><?=$team->statistic->victories??0?></span><?=Yii::t('app','Victories')?>
                    </div>
                    <div class="col-md-3 block_icon">
                        <i class="fa fa-window-close" aria-hidden="true"></i>  
                        <span><?=$team->statistic->loss??0?></span> <?=Yii::t('app','Losing')?>
                    </div>
                    <div class="col-md-3 block_icon">
                        <i class="fa fa-crosshairs" aria-hidden="true"></i> 
                        <span><?=$team->statistic->rate??0?></span> <?=Yii::t('app','W/L Rate')?>
                    </div>
                    <div class="col-md-3 block_icon">
                        <i class="fa fa-pie-chart" aria-hidden="true"></i>
                        <span><?=$team->statistic->percentage??0?></span> 
                        <i class="fa fa-percent" style="font-size: 20px;" aria-hidden="true"></i>  
                        <?=Yii::t('app','Win percentage')?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h4 class="edgtf-st-title" ><?=Yii::t('app','OUR MEMBERS')?></h4>
            </div>
            <div class="staff-box">
                <?php foreach ($members as $member): ?>
                    <?php 
                        $statistic = $member->StatisticTeam($team->id); 
                        $flag_src = FlagServis::getLinkFlag($member->country);
                    ?>
                    <div class="col-md-3 col-sm-6 col-xs-12 image_big ">
                        <a href="/user/public/<?=$member->id?>" class="item">
                            <span class="info">
                                <span class="position"><img src="<?=$flag_src?>" alt="country"></span>
                                <span class="name"><?=$member->name?></span>
                                <span class="position">@<?=$member->username?></span>
                                <br>
                                <span class="position" ><?=Yii::t('app','Fair Play')?> <?=$member->fair_play ?>%</span>
                                <span class="position" ><?=Yii::t('app','W/L')?> <?=$statistic->rate ?></span>
                                <span class="position" ><?=Yii::t('app','Wins')?> <?=$statistic->victories ?></span>
                                <span class="position" ><?=Yii::t('app','Loss')?> <?=$statistic->loss ?></span>

                                <span class="number">
                                    <i class="fab fa-twitter-square edgtf-icon-element"></i>
                                    <i class="edgtf-icon-font-awesome fab fa-youtube edgtf-icon-element"></i>
                                    <i class="edgtf-icon-font-awesome fab fa-twitch edgtf-icon-element"></i>
                                </span>
                            </span>
                            <img src="<?=$member->avatar()?>" alt="player">
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>


<!-- matches -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h4 class="edgtf-st-title" >
                <?=Yii::t('app','TRENDING MATCHES')?>
            </h4>
        </div>  
        <div class="col-md-10 col-xs-9">
            <ul class="tab-filters">
                <li class="active">
                    <a data-toggle="tab" href="#all">
                        <?=Yii::t('app','All Matches')?>
                   </a>
                </li>
                <li>
                    <a data-toggle="tab" href="#upcoming">
                        <?=Yii::t('app','Upcoming Matches')?>
                    </a>
                </li>
                <li>
                    <a data-toggle="tab" href="#last">
                        <?=Yii::t('app','Latest Results')?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="main-store-list">
    <div class="container">
        <div class="tab-content">
            <div id="all" class="tab-pane fade in active">
                <div class="row">
                    <?php foreach($matches as $match): ?>
                    <div class="col-md-12 col-sm-12">
                     <article class="edgtf-match-status-finished">
                        <div class="edgtf-match-item-holder">
                            <div class="col-md-5" style="margin-top: 15px;">
                                <div class="col-xs-4">
                                    <div class="edgtf-match-single-team">
                                        <div class="edgtf-match-item-image-holder">
                                            <img src="<?=$match->teamS->logo()?>" alt="Hacksaw">
                                        </div>
                                        <div class="edgtf-match-item-text-holder">
                                            <h6 class="edgtf-match-team-title">
                                                <a href="<?=$match->teamS->links()?>"><?=$match->teamS->name?></a>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-4" >
                                    <div class="edgtf-match-vs-image">
                                        <img src="http://playerx.edge-themes.com/wp-content/plugins/playerx-core/assets/img/vs_finished.png" alt="edgtf-match-vs-image">
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="edgtf-match-single-team">
                                        <div class="edgtf-match-item-image-holder">
                                            <img src="<?=$match->teamF->logo()?>" alt="Kaiju Red">
                                        </div>
                                        <div class="edgtf-match-item-text-holder">
                                            <h6 class="edgtf-match-team-title">
                                                <a href="<?=$match->teamF->links()?>"><?=$match->teamF->name?></a>
                                            </h6>
                                        </div>
                                    </div>  
                                </div>
                            </div>
                            <div class="col-md-3" style="margin-top: 15px;">
                                <p style="margin-top: 40px;text-align: center;font-size: 22px;font-weight: bold;" >
                                    <span><?=$match->result1??'--'?></span> : <span><?=$match->result2??'--'?></span>
                                </p>
                            </div>
                            <div class="col-md-4" style="margin-top: 15px;">
                                <div class="edgtf-match-info">
                                    <h5 class="edgtf-match-title">
                                        <a href="/tournaments/public/<?=$match->tournament->id?>">
                                            <?=$match->tournament->name?>
                                        </a>
                                    </h5>
                                    <div class="edgtf-match-date">
                                        <span class="edgtf-match-date"><?=date('dS F Y, H:i', strtotime($match->date))?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>  

                    </div>   
                    <?php endforeach; ?>   
                </div>
            </div>
            <div id="upcoming" class="tab-pane fade">
               <div class="row">
                    <?php foreach($matches as $match): ?>
                    <?php if(empty($match->result1)&&empty($match->result2)): ?>
                    <div class="col-md-12 col-sm-12">
                     <article class="edgtf-match-status-finished">
                        <div class="edgtf-match-item-holder">
                            <div class="col-md-5" style="margin-top: 15px;">
                                <div class="col-xs-4">
                                    <div class="edgtf-match-single-team">
                                        <div class="edgtf-match-item-image-holder">
                                            <img src="<?=$match->teamS->logo()?>" alt="Hacksaw">
                                        </div>
                                        <div class="edgtf-match-item-text-holder">
                                            <h6 class="edgtf-match-team-title">
                                                <a href="<?=$match->teamS->links()?>"><?=$match->teamS->name?></a>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-4" >
                                    <div class="edgtf-match-vs-image">
                                        <img src="http://playerx.edge-themes.com/wp-content/plugins/playerx-core/assets/img/vs_finished.png" alt="edgtf-match-vs-image">
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="edgtf-match-single-team">
                                        <div class="edgtf-match-item-image-holder">
                                            <img src="<?=$match->teamF->logo()?>" alt="Kaiju Red">
                                        </div>
                                        <div class="edgtf-match-item-text-holder">
                                            <h6 class="edgtf-match-team-title">
                                                <a href="<?=$match->teamF->links()?>"><?=$match->teamF->name?></a>
                                            </h6>
                                        </div>
                                    </div>  
                                </div>
                            </div>
                            <div class="col-md-3" style="margin-top: 15px;">
                                <p style="margin-top: 40px;text-align: center;font-size: 22px;font-weight: bold;" >
                                    <span><?=$match->result1??'--'?></span> : <span><?=$match->result2??'--'?></span>
                                </p>
                            </div>
                            <div class="col-md-4" style="margin-top: 15px;">
                                <div class="edgtf-match-info">
                                    <h5 class="edgtf-match-title">
                                        <a href="/tournaments/public/<?=$match->tournament->id?>">
                                            <?=$match->tournament->name?>
                                        </a>
                                    </h5>
                                    <div class="edgtf-match-date">
                                        <span class="edgtf-match-date"><?=date('dS F Y, H:i', strtotime($match->date))?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>  
                    </div> 
                    <?php endif; ?>  
                    <?php endforeach; ?>   
                </div>
            </div>
            <div id="last" class="tab-pane fade">
                <?php foreach($matches as $match): ?>
                    <?php if(!empty($match->result1)&&!empty($match->result2)): ?>
                    <div class="col-md-12 col-sm-12">
                     <article class="edgtf-match-status-finished">
                        <div class="edgtf-match-item-holder">
                            <div class="col-md-5" style="margin-top: 15px;">
                                <div class="col-xs-4">
                                    <div class="edgtf-match-single-team">
                                        <div class="edgtf-match-item-image-holder">
                                            <img src="<?=$match->teamS->logo()?>" alt="Hacksaw">
                                        </div>
                                        <div class="edgtf-match-item-text-holder">
                                            <h6 class="edgtf-match-team-title">
                                                <a href="<?=$match->teamS->links()?>">
                                                    <?=$match->teamS->name?>
                                                </a>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-4" >
                                    <div class="edgtf-match-vs-image">
                                        <img src="http://playerx.edge-themes.com/wp-content/plugins/playerx-core/assets/img/vs_finished.png" alt="edgtf-match-vs-image">
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="edgtf-match-single-team">
                                        <div class="edgtf-match-item-image-holder">
                                            <img src="<?=$match->teamF->logo()?>" alt="Kaiju Red">
                                        </div>
                                        <div class="edgtf-match-item-text-holder">
                                            <h6 class="edgtf-match-team-title">
                                                <a href="<?=$match->teamF->links()?>">
                                                    <?=$match->teamF->name?>
                                                </a>
                                            </h6>
                                        </div>
                                    </div>  
                                </div>
                            </div>
                            <div class="col-md-3" style="margin-top: 15px;">
                                <p style="margin-top: 40px;text-align: center;font-size: 22px;font-weight: bold;" >
                                    <span><?=$match->result1??'--'?></span> : <span><?=$match->result2??'--'?></span>
                                </p>
                            </div>
                            <div class="col-md-4" style="margin-top: 15px;">
                                <div class="edgtf-match-info">
                                    <h5 class="edgtf-match-title">
                                        <a href="/tournaments/public/<?=$match->tournament->id?>">
                                            <?=$match->tournament->name?>
                                        </a>
                                    </h5>
                                    <div class="edgtf-match-date">
                                        <span class="edgtf-match-date">
                                            <?=date('dS F Y, H:i', strtotime($match->date))?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>  
                    </div> 
                    <?php endif; ?>  
                <?php endforeach; ?> 
            </div>
        </div>
    </div>
</div>
<!--end  matches -->

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h4 class="edgtf-st-title" >
                <?=Yii::t('app','LIVE STREAMS')?>
            </h4>
        </div>  
        <div class="col-md-10 col-xs-9">
            <ul class="tab-filters">
                <li class="active">
                    <a data-toggle="tab" href="#twitch">
                        <?=Yii::t('app','Twitch')?>
                    </a>
                </li>
                <li>
                    <a data-toggle="tab" href="#youtubes">
                        <?=Yii::t('app','Youtube')?>
                    </a>
                </li>
                <li>
                    <a data-toggle="tab" href="#mixer">
                        <?=Yii::t('app','Mixer')?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!--  vidios -->
<div class="main-store-list">
    <div class="container">
        <div class="tab-content">
            <div id="twitch" class="tab-pane fade in active">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="edgtf-stream-box-holder  edgtf-sb-standard">
                            <div class="edgtf-sb-main-stream-item ">
                                <div class="edgtf-sb-main-stream-holder">
                                    <a class="edgtf-sb-link" href="https://mixer.com/kmagic101" target="_blank"></a>
                                    <div class="edgtf-sb-main-image">
                                        <img width="1245" height="700" src="http://playerx.edge-themes.com/wp-content/uploads/2018/06/h1-streambox-img-7.jpg" class="attachment-full size-full" alt="a" srcset="http://playerx.edge-themes.com/wp-content/uploads/2018/06/h1-streambox-img-7.jpg 1245w, http://playerx.edge-themes.com/wp-content/uploads/2018/06/h1-streambox-img-7-300x169.jpg 300w, http://playerx.edge-themes.com/wp-content/uploads/2018/06/h1-streambox-img-7-768x432.jpg 768w, http://playerx.edge-themes.com/wp-content/uploads/2018/06/h1-streambox-img-7-1024x576.jpg 1024w, http://playerx.edge-themes.com/wp-content/uploads/2018/06/h1-streambox-img-7-800x450.jpg 800w" sizes="(max-width: 1245px) 100vw, 1245px">            
                                    </div>
                                    <a class="edgtf-video-button-play" href="https://mixer.com/kmagic101" target="_blank">
                                        <span class="edgtf-video-button-play-inner">
                                            <i class="fas fa-play"></i>
                                        </span>
                                    </a>
                                    <div class="edgtf-sb-text-holder">
                                        <a href="https://mixer.com/kmagic101" target="_blank">
                                            <h5 class="edgtf-sb-title">
                                                <?=Yii::t('app','Destiny 2 Gameplay')?>
                                            </h5>
                                        </a>
                                        <div class="edgtf-sb-platform">mixer</div>
                                        <div class="edgtf-sb-channel">kmagic101</div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="edgtf-sb-bottom-stream-item ">
                                <div class="edgtf-sb-bottom-stream-holder">
                                    <a class="edgtf-sb-link" href="https://mixer.com/MetalGamerGeek" target="_blank"></a>
                                    <div class="edgtf-sb-bottom-stream-image">
                                        <img width="621" height="350" src="http://playerx.edge-themes.com/wp-content/uploads/2018/06/h1-streambox-img-8.jpg" class="attachment-full size-full" alt="a" srcset="http://playerx.edge-themes.com/wp-content/uploads/2018/06/h1-streambox-img-8.jpg 621w, http://playerx.edge-themes.com/wp-content/uploads/2018/06/h1-streambox-img-8-300x169.jpg 300w" sizes="(max-width: 621px) 100vw, 621px">            
                                    </div>
                                    <div class="edgtf-sb-text-holder">
                                        <h6 class="edgtf-sb-title">
                                            <?=Yii::t('app','OVERWATCH LIVE')?>
                                        </h6>
                                    </div>
                                </div>
                                <div class="edgtf-stream-bgrnd" style="background-image: url(http://playerx.edge-themes.com/wp-content/uploads/2018/06/h1-streambox-img-8.jpg);"></div>
                            </div>
                            <div class="edgtf-sb-bottom-stream-item ">
                                <div class="edgtf-sb-bottom-stream-holder">
                                    <a class="edgtf-sb-link" href="https://mixer.com/MR_PICKEL87" target="_blank"></a>
                                    <div class="edgtf-sb-bottom-stream-image">
                                        <img width="621" height="350" src="http://playerx.edge-themes.com/wp-content/uploads/2018/06/h1-streambox-img-9.jpg" class="attachment-full size-full" alt="a" srcset="http://playerx.edge-themes.com/wp-content/uploads/2018/06/h1-streambox-img-9.jpg 621w, http://playerx.edge-themes.com/wp-content/uploads/2018/06/h1-streambox-img-9-300x169.jpg 300w" sizes="(max-width: 621px) 100vw, 621px">            
                                    </div>
                                    <div class="edgtf-sb-text-holder">
                                        <h6 class="edgtf-sb-title">
                                            <?=Yii::t('app','Rocket League')?>
                                        </h6>
                                    </div>
                                </div>
                                <div class="edgtf-stream-bgrnd" style="background-image: url(http://playerx.edge-themes.com/wp-content/uploads/2018/06/h1-streambox-img-9.jpg);"></div>
                            </div>
                        </div>
                    </div>      
                </div>
            </div>
            
               
            </div>
        </div>
    </div>
</div>
<!-- end vidios -->


<section class="contacts-wrap">
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <?= Alert::widget()?>
                <h4 class="edgtf-st-title" ><?=Yii::t('app','CONTACT US')?></h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="col-md-12" style="margin-top: 10px;" >
                    <h3 style="margin-bottom: 0;padding-bottom: 0;" ><?=Yii::t('app','WANNA BE A')?><br> 
                        <?=Yii::t('app','PART OF THE')?> <span class="blue-font"><?=$team->name?></span> ?</h3>
                    <div class="edgtf-st-separator" style="margin-top: 3px">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="124.985px" height="3.411px" viewBox="0 0 124.985 3.411" enable-background="new 0 0 124.985 3.411" xml:space="preserve">
                            <polygon fill="#000" points="0,0 124.985,0 124.985,1.121 96.484,1.121 86.944,3.411 38.67,3.411 29.162,1.121 0,1.121 "></polygon>
                        </svg>            
                    </div>
                </div>

                <div class="col-md-12">
                    <p style="margin-top: 50px;">
                        Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris morbi accumsan ut.
                    </p>
                </div>
                
            </div>
            <div class="col-md-6"> 
                <div class="leave-comment-wrap">
                    <form action="/teams/contact/<?=$team->id?>" method="POST" >
                        <div class="row">
                            <?= Html::hiddenInput(\Yii::$app->getRequest()->csrfParam, \Yii::$app->getRequest()->getCsrfToken(), []);?>
                            <div class="col-md-12">
                                <div class="item">
                                    <input type="text" value="<?=Yii::$app->user->identity->name?>" name="name" placeholder="Your Name" required>
                                </div>  
                            </div>
                            <div class="col-md-12">
                                <div class="item">
                                    <input type="email" value="<?=Yii::$app->user->identity->email?>" name="email" placeholder="Email" required>
                                </div>  
                            </div>
                            <div class="col-md-12">
                                <div class="item">
                                    <textarea name="message" required ><?=Yii::t('app','Your message')?>
                                    </textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button class="comment-submit" style="width: 100%;" type="submit">
                                    <?=Yii::t('app','Send us message')?>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

