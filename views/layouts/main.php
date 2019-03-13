<?php

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use \yii\helpers\Url;
use app\models\servises\FlagServis;
//use Yii;

$alias = Yii::$app->params['domains'];

AppAsset::register($this);
$this->registerCssFile(
    "css/domains/{$alias}.css", 
    ['depends' => ['app\assets\AppAsset']]
);

$script = "
    $.language_n18 = {
        sorry: \"".Yii::t('app','Sorry, we can\'t find what you\'re looking for. Give it another whirl.')."\",
        teams: \"".Yii::t('app','Teams')."\",
        registration: \" ".Yii::t('app','Registration date')." \",
        game:  \"".Yii::t('app','Game')."\",
        members: \"".Yii::t('app','Members')."\",
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

<body  class="edgtf-header-standard edgtf-header-divided">
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

<!--     <div class="top-bar">
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
                                    <img src="<?//FlagServis::getLinkFlagLoc()?>" alt="selected language">
                                    <?//substr(Yii::$app->language, 0, 2)?>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="/site/translations?lang=fr-FR">
                                            <img src="<?//FlagServis::getLinkFlag('France')?>" alt="language">FR
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/site/translations?lang=en-EN">
                                            <img src="<?//FlagServis::getLinkFlag('United Kingdom')?>" alt="language">EN
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/site/translations?lang=es-ES">
                                            <img src="<?//FlagServis::getLinkFlag('Spain')?>" alt="language">ES
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
    </div> -->

    <!--MAIN MENU WRAP BEGIN-->
  <header class="edgtf-page-header">
        <div class="edgtf-menu-area" style="opacity: 1;">
            <div class="edgtf-vertical-align-containers">
            <div class="edgtf-position-left" >
                <div class="edgtf-divided-left-widget-area">
                <div class="edgtf-divided-left-widget-area-inner">

                    <a class="edgtf-search-opener edgtf-icon-has-hover edgtf-search-opener-svg-path" href="javascript:void(0)">
                        <span class="edgtf-search-opener-wrapper" id="search-bar">
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="25.34px" height="25.341px" viewBox="0 0 25.34 25.341" enable-background="new 0 0 25.34 25.341" xml:space="preserve">
                                <path fill="#ffffff" d="M25.34,22.409l-6.343-6.343c1.084-1.637,1.719-3.598,1.719-5.708C20.716,4.637,16.079,0,10.358,0
                                S0,4.637,0,10.358s4.637,10.358,10.358,10.358c2.11,0,4.071-0.635,5.708-1.718l6.343,6.343L25.34,22.409z M4,10.358
                                C4,6.852,6.852,4,10.358,4s6.358,2.852,6.358,6.358c0,1.638-0.628,3.128-1.649,4.256l-0.451,0.451
                                c-1.128,1.022-2.62,1.65-4.258,1.65C6.852,16.716,4,13.864,4,10.358z"></path>
                            </svg>
                        </span>
                        </a>
                    </div>
                </div>
                <div class="edgtf-position-left-inner">
                    <div class="edgtf-divided-left-inner-border-holder"></div>
                    <div class="edgtf-divided-left-inner-top-widget-area">
                        <div class="edgtf-divided-left-inner-top-widget-area-inner">
                            <div id="text-2" class="widget widget_text edgtf-header-divided-left-top-widget-area">          
                                <div class="textwidget">
                                    <p><span style="margin-right:26px">follow us on:</span></p>
                                </div>
                            </div>
                            <div class="widget edgtf-social-icons-group-widget text-align-right"> 
                                <a class="edgtf-social-icon-widget-holder edgtf-icon-has-hover"  href="">
                                    <i class="fa fa-instagram" aria-hidden="true"></i>    
                                </a>
                                <a class="edgtf-social-icon-widget-holder edgtf-icon-has-hover"  href="">
                                    <i class="fa fa-pinterest" aria-hidden="true"></i>    
                                </a>                                
                            </div>                        
                        </div>
                    </div>

                   <!--  <nav class="edgtf-main-menu edgtf-drop-down edgtf-divided-left-part edgtf-default-nav">
                        <ul id="menu-divided-left-navigation" class="clearfix">
                            <li id="nav-menu-item-239" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-ancestor current-menu-parent menu-item-has-children edgtf-active-item has_sub narrow">
                                <a href="#" class=" current ">
                                    <span class="item_outer">
                                        <span class="item_text">Home</span><i class="edgtf-menu-arrow fa fa-angle-down"></i>
                                    </span>
                                </a>
                            <div class="second" style="height: 0px; visibility: hidden; top: 150%; opacity: 0; overflow: hidden;">
                                <div class="inner"><ul>
                                <li id="nav-menu-item-242" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-6 current_page_item "><a href="http://playerx.edge-themes.com/" class=""><span class="item_outer"><span class="item_text">Main Home</span></span></a></li>
                                <li id="nav-menu-item-469" class="menu-item menu-item-type-post_type menu-item-object-page "><a href="http://playerx.edge-themes.com/development-studio/" class=""><span class="item_outer"><span class="item_text">Development Studio</span></span></a></li>
                                <li id="nav-menu-item-1904" class="menu-item menu-item-type-post_type menu-item-object-page "><a href="http://playerx.edge-themes.com/portfolio-carousel/" class=""><span class="item_outer"><span class="item_text">Portfolio Carousel</span></span></a></li>
                                <li id="nav-menu-item-725" class="menu-item menu-item-type-post_type menu-item-object-page "><a href="http://playerx.edge-themes.com/esports-home/" class=""><span class="item_outer"><span class="item_text">eSports Home</span></span></a></li>
                                <li id="nav-menu-item-726" class="menu-item menu-item-type-post_type menu-item-object-page "><a href="http://playerx.edge-themes.com/parallax-home/" class=""><span class="item_outer"><span class="item_text">Parallax Home</span></span></a></li>
                                <li id="nav-menu-item-1012" class="menu-item menu-item-type-post_type menu-item-object-page "><a href="http://playerx.edge-themes.com/vcard/" class=""><span class="item_outer"><span class="item_text">vCard</span></span></a></li>
                                <li id="nav-menu-item-1011" class="menu-item menu-item-type-post_type menu-item-object-page "><a href="http://playerx.edge-themes.com/coming-soon/" class=""><span class="item_outer"><span class="item_text">Coming Soon</span></span></a></li>
                                <li id="nav-menu-item-2478" class="menu-item menu-item-type-post_type menu-item-object-page "><a target="_blank" href="http://playerx.edge-themes.com/landing/" class=""><span class="item_outer"><span class="item_text">Landing</span></span></a></li>
                            </ul></div></div>
                        </li>
                        <li id="nav-menu-item-240" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children  has_sub narrow"><a href="#" class=""><span class="item_outer"><span class="item_text">Pages</span><i class="edgtf-menu-arrow fa fa-angle-down"></i></span></a>
                            <div class="second" style="height: 0px; visibility: hidden; top: 150%; opacity: 0; overflow: hidden;"><div class="inner"><ul>
                                <li id="nav-menu-item-2798" class="menu-item menu-item-type-post_type menu-item-object-page "><a href="http://playerx.edge-themes.com/about-the-clan/" class=""><span class="item_outer"><span class="item_text">About The Clan</span></span></a></li>
                                <li id="nav-menu-item-1181" class="menu-item menu-item-type-post_type menu-item-object-page "><a href="http://playerx.edge-themes.com/about-me/" class=""><span class="item_outer"><span class="item_text">About Me</span></span></a></li>
                                <li id="nav-menu-item-1394" class="menu-item menu-item-type-post_type menu-item-object-page "><a href="http://playerx.edge-themes.com/our-squad/" class=""><span class="item_outer"><span class="item_text">Our Squad</span></span></a></li>
                                <li id="nav-menu-item-2752" class="menu-item menu-item-type-post_type menu-item-object-match-item "><a href="http://playerx.edge-themes.com/match-item/nay-corral-gundown/" class=""><span class="item_outer"><span class="item_text">Match Single</span></span></a></li>
                                <li id="nav-menu-item-1320" class="menu-item menu-item-type-post_type menu-item-object-page "><a href="http://playerx.edge-themes.com/faq-page/" class=""><span class="item_outer"><span class="item_text">FAQ Page</span></span></a></li>
                                <li id="nav-menu-item-1179" class="menu-item menu-item-type-post_type menu-item-object-page "><a href="http://playerx.edge-themes.com/contact-us/" class=""><span class="item_outer"><span class="item_text">Contact Us</span></span></a></li>
                            </ul></div></div>
                        </li>
                        <li id="nav-menu-item-241" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children  has_sub narrow"><a href="#" class=""><span class="item_outer"><span class="item_text">Portfolio</span><i class="edgtf-menu-arrow fa fa-angle-down"></i></span></a>
                            <div class="second" style="height: 0px; visibility: hidden; top: 150%; opacity: 0; overflow: hidden;"><div class="inner"><ul>
                                <li id="nav-menu-item-1782" class="menu-item menu-item-type-post_type menu-item-object-page "><a href="http://playerx.edge-themes.com/portfolio/standard/" class=""><span class="item_outer"><span class="item_text">Standard</span></span></a></li>
                                <li id="nav-menu-item-1780" class="menu-item menu-item-type-post_type menu-item-object-page "><a href="http://playerx.edge-themes.com/portfolio/gallery/" class=""><span class="item_outer"><span class="item_text">Gallery</span></span></a></li>
                                <li id="nav-menu-item-1781" class="menu-item menu-item-type-post_type menu-item-object-page "><a href="http://playerx.edge-themes.com/portfolio/masonry/" class=""><span class="item_outer"><span class="item_text">Masonry</span></span></a></li>
                                <li id="nav-menu-item-1783" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children sub"><a href="#" class=""><span class="item_outer"><span class="item_text">Layouts</span></span></a>
                                    <ul>
                                        <li id="nav-menu-item-1789" class="menu-item menu-item-type-post_type menu-item-object-page "><a href="http://playerx.edge-themes.com/portfolio/two-columns/" class=""><span class="item_outer"><span class="item_text">Two Columns</span></span></a></li>
                                        <li id="nav-menu-item-1788" class="menu-item menu-item-type-post_type menu-item-object-page "><a href="http://playerx.edge-themes.com/portfolio/three-columns/" class=""><span class="item_outer"><span class="item_text">Three Columns</span></span></a></li>
                                        <li id="nav-menu-item-1787" class="menu-item menu-item-type-post_type menu-item-object-page "><a href="http://playerx.edge-themes.com/portfolio/three-columns-wide/" class=""><span class="item_outer"><span class="item_text">Three Columns Wide</span></span></a></li>
                                        <li id="nav-menu-item-1785" class="menu-item menu-item-type-post_type menu-item-object-page "><a href="http://playerx.edge-themes.com/portfolio/four-columns/" class=""><span class="item_outer"><span class="item_text">Four Columns</span></span></a></li>
                                        <li id="nav-menu-item-1786" class="menu-item menu-item-type-post_type menu-item-object-page "><a href="http://playerx.edge-themes.com/portfolio/four-columns-wide/" class=""><span class="item_outer"><span class="item_text">Four Columns Wide</span></span></a></li>
                                        <li id="nav-menu-item-1784" class="menu-item menu-item-type-post_type menu-item-object-page "><a href="http://playerx.edge-themes.com/portfolio/five-columns-wide/" class=""><span class="item_outer"><span class="item_text">Five Columns Wide</span></span></a></li>
                                    </ul>
                                </li>
                                <li id="nav-menu-item-1790" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children sub"><a href="#" class=""><span class="item_outer"><span class="item_text">Single</span></span></a>
                                    <ul>
                                        <li id="nav-menu-item-1795" class="menu-item menu-item-type-post_type menu-item-object-portfolio-item "><a href="http://playerx.edge-themes.com/portfolio-item/falls-barrow/" class=""><span class="item_outer"><span class="item_text">Small Images</span></span></a></li>
                                        <li id="nav-menu-item-1793" class="menu-item menu-item-type-post_type menu-item-object-portfolio-item "><a href="http://playerx.edge-themes.com/portfolio-item/the-dark-blade/" class=""><span class="item_outer"><span class="item_text">Small Slider</span></span></a></li>
                                        <li id="nav-menu-item-1796" class="menu-item menu-item-type-post_type menu-item-object-portfolio-item "><a href="http://playerx.edge-themes.com/portfolio-item/before-the-storm/" class=""><span class="item_outer"><span class="item_text">Big Images</span></span></a></li>
                                        <li id="nav-menu-item-1794" class="menu-item menu-item-type-post_type menu-item-object-portfolio-item "><a href="http://playerx.edge-themes.com/portfolio-item/dragon-rising/" class=""><span class="item_outer"><span class="item_text">Big Slider</span></span></a></li>
                                        <li id="nav-menu-item-1791" class="menu-item menu-item-type-post_type menu-item-object-portfolio-item "><a href="http://playerx.edge-themes.com/portfolio-item/the-eye-of-magnus/" class=""><span class="item_outer"><span class="item_text">Small Gallery</span></span></a></li>
                                        <li id="nav-menu-item-1792" class="menu-item menu-item-type-post_type menu-item-object-portfolio-item "><a href="http://playerx.edge-themes.com/portfolio-item/moon-eclipse/" class=""><span class="item_outer"><span class="item_text">Big Gallery</span></span></a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        </div>
                        </li>
                        </ul>   
                    </nav> -->
                </div> 
            </div>
            <div class="edgtf-position-center">
                <div class = "edgtf-position-center-inner" style = "background-color: #005DB4">
                    <div class="edgtf-logo-wrapper">
                        <a  href="/" style="height: 60px;margin-top:7px;">
                            <img  class="edgtf-normal-logo" src="/images/hockey/logo-background-img.png" alt="logo">       
                        </a>
                    </div>
                </div>
            </div>
            <div class="edgtf-position-right">
            <div class="edgtf-position-right-inner">
                <div class="edgtf-divided-right-inner-border-holder"></div>
                <div class="edgtf-divided-right-inner-top-widget-area">
                    <div class="edgtf-divided-right-inner-top-widget-area-inner">
                        <div class="textwidget">
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
                        </div>
                    </div>
                </div>

                <nav class="edgtf-main-menu edgtf-drop-down edgtf-divided-right-part edgtf-default-nav">
                    <ul id="menu-divided-right-navigation" class="clearfix">
                        <li id="nav-menu-item-243" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children  has_sub narrow <?=$this->context->route == 'site/index' ? 'edgtf-active-item' : ''?> ">
                            <a href="/" class="">
                                <span class="item_outer"><span class="item_text"><?=Yii::t('app','Home')?></span>
                                <i class="edgtf-menu-arrow fa fa-angle-down"></i></span>
                            </a>
                            <div class="second right" >
                                <div class="inner">
                                    <ul class="right">
                                    <li id="nav-menu-item-248" class="menu-item menu-item-type-post_type menu-item-object-page "><a href="http://playerx.edge-themes.com/blog/right-sidebar/" class=""><span class="item_outer"><span class="item_text">Right Sidebar</span></span></a></li>
                                    <li id="nav-menu-item-1672" class="menu-item menu-item-type-post_type menu-item-object-page "><a href="http://playerx.edge-themes.com/blog/left-sidebar/" class=""><span class="item_outer"><span class="item_text">Left Sidebar</span></span></a></li>
                                    <li id="nav-menu-item-1671" class="menu-item menu-item-type-post_type menu-item-object-page "><a href="http://playerx.edge-themes.com/blog/no-sidebar/" class=""><span class="item_outer"><span class="item_text">No Sidebar</span></span></a></li>
                                    <li id="nav-menu-item-249" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children sub"><a href="#" class=""><span class="item_outer"><span class="item_text">Post Types</span></span></a>
                                        <ul class="right">
                                            <li id="nav-menu-item-254" class="menu-item menu-item-type-post_type menu-item-object-post "><a href="http://playerx.edge-themes.com/white-keep-assault/" class=""><span class="item_outer"><span class="item_text">Standard</span></span></a></li>
                                            <li id="nav-menu-item-253" class="menu-item menu-item-type-post_type menu-item-object-post "><a href="http://playerx.edge-themes.com/dota-2-tournament/" class=""><span class="item_outer"><span class="item_text">Gallery</span></span></a></li>
                                            <li id="nav-menu-item-252" class="menu-item menu-item-type-post_type menu-item-object-post "><a href="http://playerx.edge-themes.com/black-angels/" class=""><span class="item_outer"><span class="item_text">Link</span></span></a></li>
                                            <li id="nav-menu-item-250" class="menu-item menu-item-type-post_type menu-item-object-post "><a href="http://playerx.edge-themes.com/heros-journey/" class=""><span class="item_outer"><span class="item_text">Quote</span></span></a></li>
                                            <li id="nav-menu-item-255" class="menu-item menu-item-type-post_type menu-item-object-post "><a href="http://playerx.edge-themes.com/a-time-travel-tale/" class=""><span class="item_outer"><span class="item_text">Video</span></span></a></li>
                                            <li id="nav-menu-item-251" class="menu-item menu-item-type-post_type menu-item-object-post "><a href="http://playerx.edge-themes.com/winners-on-esl-pro/" class=""><span class="item_outer"><span class="item_text">Audio</span></span></a></li>
                                        </ul>
                                    </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <?php
                            if(Yii::$app->user->isGuest):
                        ?>
                            <li id="nav-menu-item-244" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children  has_sub narrow <?=$this->context->route == 'site/login' ? 'edgtf-active-item' : ''?> ">
                                <a href="/login" class="">
                                    <span class="item_outer">
                                        <span class="item_text"><?=Yii::t('app','Sign in')?></span>
                                    </span>
                                </a>
                            </li>
                            <li id="nav-menu-item-244" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children  has_sub narrow  <?=$this->context->route == 'site/register' ? 'edgtf-active-item' : ''?>">
                                <a href="/register" class="">
                                    <span class="item_outer">
                                        <span class="item_text"><?=Yii::t('app','Sign up')?></span>
                                        <i class="edgtf-menu-arrow fa fa-angle-down"></i>
                                    </span>
                                </a>
                            </li>

                        <?php else : ?>
                        <li id="nav-menu-item-244" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children  has_sub narrow">
                            <a href="#" class="">
                                <span class="item_outer">
                                    <span class="item_text">
                                        <?=Yii::t('app','Hi')?>, 
                                        <?=Yii::$app->user->identity->username?></span>
                                    <i class="edgtf-menu-arrow fa fa-angle-down"></i>
                                </span>
                            </a>
                            <div class="second right" >
                                <div class="inner">
                                    <ul class="right">
                                        <li id="nav-menu-item-246" class="menu-item menu-item-type-post_type menu-item-object-product ">
                                            <a href="/profile" class="">
                                                <span class="item_outer">
                                                    <span class="item_text"><?=Yii::t('app','My profile')?></span>
                                                </span>
                                            </a>
                                        </li>
                                        <li id="nav-menu-item-1517" class="menu-item menu-item-type-post_type menu-item-object-product">
                                            <a href="/logout" class="">
                                                <span class="item_outer">
                                                    <span class="item_text"><?=Yii::t('app','Logout')?></span>
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li style="padding-top:15px;" >
                             <a  href="/profile#activity" class="block-add-message" ></a>
                        </li>
                        <?php endif;?>
                    </ul>
                </nav>
            </div>
            <div class="edgtf-divided-right-widget-area">
                <div class="edgtf-divided-right-widget-area-inner">
                    <div class="edgtf-position-right-inner-wrap">

                        <a class="edgtf-side-menu-button-opener edgtf-icon-has-hover edgtf-side-menu-button-opener-svg-path" href="javascript:void(0)">
                            <span class="edgtf-side-menu-icon">
                                <svg version="1.1" class="edgtf-side-area-opener" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="23.922px" height="23.916px" viewBox="0 0 23.922 23.916" enable-background="new 0 0 23.922 23.916" xml:space="preserve">
                                    <rect x="2.604" y="14.698" transform="matrix(0.7071 0.7071 -0.7071 0.7071 14.9741 2.3277)" fill="#ffffff" width="4.146" height="9.083"></rect>
                                    <rect x="17.166" y="0.135" transform="matrix(0.7072 0.707 -0.707 0.7072 8.9391 -12.2324)" fill="#ffffff" width="4.145" height="9.083"></rect>
                                    <rect x="2.61" y="0.141" transform="matrix(-0.7071 0.7071 -0.7071 -0.7071 11.3045 4.6818)" fill="#ffffff" width="4.145" height="9.083"></rect>
                                    <rect x="17.172" y="14.703" transform="matrix(-0.7071 0.7071 -0.7071 -0.7071 46.4606 19.2446)" fill="#ffffff" width="4.146" height="9.083"></rect>
                                </svg>            
                            </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
  </header>



<header class="edgtf-mobile-header" style="margin-bottom: 0px;">
    <div class="edgtf-mobile-header-inner">
        <div class="edgtf-mobile-header-holder">
            <div class="edgtf-grid">
                <div class="edgtf-vertical-align-containers">
                    <div class="edgtf-vertical-align-containers">
                        <div class="edgtf-mobile-menu-opener edgtf-mobile-menu-opener-svg-path edgtf-mobile-menu-opened">
                            <a href="javascript:void(0)">
                                <span class="edgtf-mobile-menu-icon">
                                    <svg version="1.1" class="edgtf-mobile-opener-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="23.922px" height="23.916px" viewBox="0 0 23.922 23.916" enable-background="new 0 0 23.922 23.916" xml:space="preserve">
                                        <rect x="2.604" y="14.698" transform="matrix(0.7071 0.7071 -0.7071 0.7071 14.9741 2.3277)" fill="#ffffff" width="4.146" height="9.083"></rect>
                                        <rect x="17.166" y="0.135" transform="matrix(0.7072 0.707 -0.707 0.7072 8.9391 -12.2324)" fill="#ffffff" width="4.145" height="9.083"></rect>
                                        <rect x="2.61" y="0.141" transform="matrix(-0.7071 0.7071 -0.7071 -0.7071 11.3045 4.6818)" fill="#ffffff" width="4.145" height="9.083"></rect>
                                        <rect x="17.172" y="14.703" transform="matrix(-0.7071 0.7071 -0.7071 -0.7071 46.4606 19.2446)" fill="#ffffff" width="4.146" height="9.083"></rect>
                                    </svg>                                  
                                </span>
                                </a>
                        </div>
                        <div class="edgtf-position-center">
                            <div class="edgtf-position-center-inner">
                                <div class="edgtf-mobile-logo-wrapper">
                                    <a itemprop="url" href="http://playerx.edge-themes.com/" style="height: 42px">
                                        <img itemprop="image" src="http://playerx.edge-themes.com/wp-content/uploads/2018/06/logo-header.png" width="85" height="84" alt="Mobile Logo">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="edgtf-position-right">
                            <div class="edgtf-position-right-inner"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <nav class="edgtf-mobile-nav ps ps--theme_default ps--active-y"  style="height: 104px; display: block;">
            <div class="edgtf-grid">
                <ul id="menu-main-menu-navigation" class="">
                    <li id="mobile-menu-item-35" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-ancestor current-menu-parent menu-item-has-children edgtf-active-item has_sub"><a href="#" class=" current  edgtf-mobile-no-link"><span>Home</span></a><span class="mobile_arrow"><i class="edgtf-sub-arrow fa fa-angle-right"></i><i class="fa fa-angle-down"></i></span>

                    </li>
                    <li id="mobile-menu-item-36" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children  has_sub"><a href="#" class=" edgtf-mobile-no-link"><span>Pages</span></a>
                        <span class="mobile_arrow">
                            <i class="edgtf-sub-arrow fa fa-angle-right"></i><i class="fa fa-angle-down"></i>
                        </span>
                    </li>
                    <li id="mobile-menu-item-37" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children  has_sub"><a href="#" class=" edgtf-mobile-no-link"><span>Portfolio</span></a><span class="mobile_arrow"><i class="edgtf-sub-arrow fa fa-angle-right"></i><i class="fa fa-angle-down"></i></span>
                       
                    </li>
                    <li id="mobile-menu-item-38" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children  has_sub"><a href="#" class=" edgtf-mobile-no-link"><span>Blog</span></a><span class="mobile_arrow"><i class="edgtf-sub-arrow fa fa-angle-right"></i><i class="fa fa-angle-down"></i></span>
                       >
                    </li>
                    <li id="mobile-menu-item-39" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children  has_sub"><a href="#" class=" edgtf-mobile-no-link"><span>Shop</span></a><span class="mobile_arrow"><i class="edgtf-sub-arrow fa fa-angle-right"></i><i class="fa fa-angle-down"></i></span>
                    </li>
                    <li id="mobile-menu-item-40" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children  has_sub edgtf-opened"><a href="#" class=" edgtf-mobile-no-link"><span>Elements</span></a><span class="mobile_arrow"><i class="edgtf-sub-arrow fa fa-angle-right"></i><i class="fa fa-angle-down"></i></span>
                       
                    </li>
                </ul>    
            </div>
            <div class="ps__scrollbar-x-rail" style="left: 0px; bottom: -160px;">
                <div class="ps__scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div>
            </div>
            <div class="ps__scrollbar-y-rail" style="top: 160px; right: 0px; height: 104px;">
                <div class="ps__scrollbar-y" tabindex="0" style="top: 39px; height: 25px;"></div>
            </div>
        </nav>

    </div>
</header>







   <!--  <div class="main-menu-wrap sticky-menu">
    <div class="container">
        <a href="/" class="custom-logo-link"><img src="/images/hockey/logo.png" alt="logo" class="custom-logo"></a>
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#team-menu" aria-expanded="false">
            <span class="sr-only"><?//Yii::t('app','Toggle navigation')?></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <nav class="navbar">
            <div class="collapse navbar-collapse" id="team-menu">
                <ul class="main-menu nav">
                    <li class="<?//$this->context->route == 'site/index' ? 'active' : ''?>">
                        <a href="/"><span><?//Yii::t('app','Home')?></span></a>
                    </li>
                    <?php
                       // if(Yii::$app->user->isGuest):
                    ?>
                        <li class="<?//$this->context->route == 'site/login' ? 'active' : ''?>">
                            <a href="/login"><span><?//Yii::t('app','Sign in')?></span></a>
                        </li>
                        <li class="<?//$this->context->route == 'site/register' ? 'active' : ''?>">
                            <a href="/register"><span><?//Yii::t('app','Sign up')?></span></a>
                        </li>
                    <?php
                        //else:
                    ?>
                        <li>
                            <a href="/" >
                                <span><?//Yii::t('app','Hi')?>, <?//Yii::$app->user->identity->username?></span>
                            </a>
                            <ul>
                                <li><a href="/profile"><span><?//Yii::t('app','My profile')?></span></a></li>
                                <li><a href="/logout"><span><?//Yii::t('app','Logout')?></span></a></li>
                            </ul>
                        </li>
                        <li >
                             <a  href="/profile#activity" class="block-add-message" ></a>
                        </li>
                    <?php
                      //  endif;
                    ?>
                </ul>
            </div>       
        </nav>
    </div>
    </div> -->
    
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
                            <a href="/" class="foot-logo">
                                <img src="/images/hockey/logo-background-img.png" alt="footer-logo"
                                    style="height: 50px;" 
                                >
                            </a>
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
                            <a href="news.html" class="image">
                                <img class="img-responsive" src="/images/hockey/foot-news-img.jpg" alt="news-image"></a>
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


