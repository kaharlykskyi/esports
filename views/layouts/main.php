<?php

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use \yii\helpers\Url;
use app\models\servises\FlagServis;
use Yii;

$alias = Yii::$app->params['domains'];

AppAsset::register($this);
$this->registerCssFile(
    "css/domains/{$alias}.css", 
    ['depends' => ['app\assets\AppAsset']]
);

$script = "
    $.language_n18 = {
        sorry: '".Yii::t('app','Sorry, we can\'t find what you\'re looking for. Give it another whirl.')."',
        teams: '".Yii::t('app','Teams')."',
        registration: \" ".Yii::t('app','Registration date')." \",
        game:  '".Yii::t('app','Game')."',
        members: '".Yii::t('app','Members')."',
        start: \" ".Yii::t('app','Start date')." \"
    };
    ";
    $this->registerJs($script, yii\web\View::POS_END);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Montserrat%7COpen+Sans:700,400%7CRaleway:400,800,900" rel="stylesheet" />
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <?= Html::csrfMetaTags() ?>
    <title><?=$this->title?></title>
    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>
<div class="wrap_search_fon"> <!-- wrap_blur -->
    
	<div class="preloader-wrapper" id="preloader">
        <div class="motion-line dark-big"></div>
        <div class="motion-line yellow-big"></div>
        <div class="motion-line dark-small"></div>
        <div class="motion-line yellow-normal"></div>
        <div class="motion-line yellow-small1"></div>
        <div class="motion-line yellow-small2"></div>
    </div>

    <div class="top-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-7 hidden-sm hidden-xs">
                <div class="top-contacts">
                    <ul class="socials">
                        <li><a href="#"><i class="fa fa-facebook-square" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-google" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                    </ul>
                    <ul class="contacts">
                        <li class="phone"><i class="fa fa-phone-square" aria-hidden="true"></i>+61 3 8376 6284</li>
                        <li class="skype"><a href="callto:team.skype"><i class="fa fa-skype" aria-hidden="true"></i>team.skype</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-5">
                <div class="top-language">
                    <ul class="list">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="<?=FlagServis::getLinkFlagLoc()?>" alt="selected language">
                                <?=substr(Yii::$app->language, 0, 2)?>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="/site/translations?lang=fr-FR">
                                        <img src="<?=FlagServis::getLinkFlag('France')?>" alt="language">FR
                                    </a>
                                </li>
                                <li>
                                    <a href="/site/translations?lang=en-EN">
                                        <img src="<?=FlagServis::getLinkFlag('United Kingdom')?>" alt="language">EN
                                    </a>
                                </li>
                                <li>
                                    <a href="/site/translations?lang=es-ES">
                                        <img src="<?=FlagServis::getLinkFlag('Spain')?>" alt="language">ES
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                    <div class="top-search clearfix" id="search-bar">
                        <button tyle="width: 50px;"><i class="fa fa-search" aria-hidden="true"></i></button>
                    </div>

                    <div class="clear"></div>
            </div>
        </div>
    </div>
    </div>

    <!--MAIN MENU WRAP BEGIN-->
    <div class="main-menu-wrap sticky-menu">
    <div class="container">
        <a href="/" class="custom-logo-link"><img src="/images/hockey/logo.png" alt="logo" class="custom-logo"></a>
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#team-menu" aria-expanded="false">
            <span class="sr-only"><?=Yii::t('app','Toggle navigation')?></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <nav class="navbar">
            <div class="collapse navbar-collapse" id="team-menu">
                <ul class="main-menu nav">
                    <li class="<?=$this->context->route == 'site/index' ? 'active' : ''?>">
                        <a href="/"><span><?=Yii::t('app','Home')?></span></a>
                    </li>
                    <?php
                        if(Yii::$app->user->isGuest):
                    ?>
                        <li class="<?=$this->context->route == 'site/login' ? 'active' : ''?>">
                            <a href="/login"><span><?=Yii::t('app','Sign in')?></span></a>
                        </li>
                        <li class="<?=$this->context->route == 'site/register' ? 'active' : ''?>">
                            <a href="/register"><span><?=Yii::t('app','Sign up')?></span></a>
                        </li>
                    <?php
                        else:
                    ?>
                        <li>
                            <a href="/"><span><?=Yii::t('app','Hi')?>, <?=Yii::$app->user->identity->username?></span></a>
                            <ul>
                                <li><a href="/profile"><span><?=Yii::t('app','My profile')?></span></a></li>
                                <li><a href="/logout"><span><?=Yii::t('app','Logout')?></span></a></li>
                            </ul>
                        </li>
                    <?php
                        endif;
                    ?>
                </ul>
            </div>       
        </nav>
    </div>
    </div>

    <?//Alert::widget() ?>
    <?= $content ?>
<!--MAIN MENU WRAP END-->

<!--FOOTER BEGIN-->
    <footer class="footer">
    <div class="wrapper-overfllow">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-12">
                    <div class="footer-left">
                        <div class="wrap">
                            <a href="index.html" class="foot-logo"><img src="/images/hockey/footer-logo.png" alt="footer-logo"></a>
                            <p>Activated charcoal trust fund ugh prism af, beard marfa air plant stumptown gastropub farm-to-table jianbing.</p>
                            <ul class="foot-left-menu">
                                <li><a href="staff.html">First team</a></li>
                                <li><a href="staff.html">Second team</a></li>
                                <li><a href="amateurs.html">Amateurs</a></li>
                                <li><a href="donations.html">Donation</a></li>
                                <li><a href="trophies.html">trophies</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 col-lg-offset-1">
                    <div class="foot-news">
                        <h4>Recent news</h4>
                        <div class="item">
                            <a href="news.html" class="image"><img class="img-responsive" src="/images/hockey/foot-news-img.jpg" alt="news-image"></a>
                            <a href="news.html" class="name">When somersaulting Sanchez shouldered Mexico’s hopes</a>
                            <a href="news.html" class="date">25 Sep 2016</a>
                            <span class="separator">in</span>
                            <a href="news.html" class="category">Highlights</a>
                        </div>
                    </div>
                </div>
                <div class=" col-lg-3 col-md-4 col-sm-12">
                    <div class="foot-contact">
                        <h4>Contact us</h4>
                        <ul class="contact-list">
                            <li><i class="fa fa-flag" aria-hidden="true"></i><span>276 Upper Parliament Street, Liverpool L8, Great Britain</span></li>
                            <li><i class="fa fa-envelope" aria-hidden="true"></i><a href="mailto:team@email.com">team@email.com</a></li>
                            <li class="phone"><i class="fa fa-phone" aria-hidden="true"></i><span>+61 3 8376 6284</span></li>
                        </ul>
                        <ul class="socials">
                            <li><a href="#"><i class="fa fa-facebook-square" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fa fa-google" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-menu-wrap">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="footer-menu">
                        <li class="active"><a href="index.html"><span>Home</span></a></li>
                        <li><a href="matches.html"><span>Matches</span></a></li>
                        <li><a href="staff.html"><span>Team</span></a></li>
                        <li><a href="news.html"><span>News</span></a></li>
                        <li><a href="store.html"><span>Store</span></a></li>
                        <li><a href="contacts.html"><span>Contact</span></a></li>
                    </ul>	
                    <a href="#top" class="foot-up"><span>up <i class="fa fa-caret-up" aria-hidden="true"></i></span></a>
                </div>
            </div>
        </div>
    </div>
    </footer>
</div>
<!--FOOTER END-->

<!--SEARCH BAR BEGIN-->

<div class="s_layouts_snapWrapper">
    <div class="container container_search">
        <div class="row">
            <div class="s_layouts_snapInputWrapper">
                <input type="text" class="s_layouts_snapInput" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" placeholder="<?=Yii::t('app','So, what are you looking for')?>?">
                <div class="s_layouts_snapClose">
                    <span class="close"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="s_layouts_snapHeaderWrapper">
                <div class="s_layouts_snapTabs">
                    <span class="s_layouts_snapTab all_snapTab" data-search-menu="0" style="display:none;" >
                        <?=Yii::t('app','All Results')?>
                    </span>
                    <span class="s_layouts_snapTab users_snapTab" data-search-menu="1" style="display:none;" >
                        <?=Yii::t('app','User profiles')?>
                    </span>
                    <span class="s_layouts_snapTab teams_snapTab" data-search-menu="2" style="display:none;">
                        <?=Yii::t('app','Teams')?>
                    </span>
                    <span class="s_layouts_snapTab tournaments_snapTab" data-search-menu="3" style="display:none;" >
                        <?=Yii::t('app','Tournaments')?>
                    </span>
                </div>
            </div>
        </div>
       <div class="row container_search_modal">
               
        </div>
        <div class="s_layouts_snapMessageWrapper">
            <p class="img_downloder" style="display: none;" ><img src="/images/profile/45.gif"></p>
            <p class="message_search"></p>
        </div>
    </div>
</div>

<!--SEARCH BAR END-->

<?php $this->endBody() ?>
</body>
</html>

<?php $this->endPage() ?>


