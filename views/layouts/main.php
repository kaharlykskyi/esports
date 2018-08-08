<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use \yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Montserrat%7COpen+Sans:700,400%7CRaleway:400,800,900" rel="stylesheet" />
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <?= Html::csrfMetaTags() ?>
    <title><?=$this->title?></title>
    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>
<div>
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
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="/images/common/en-flag.png" alt="selected language">EN</a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="#"><img src="/images/common/fr-flag.png" alt="language">FR</a>
                                </li>
                                <li>
                                    <a href="#"><img src="/images/common/en-flag.png" alt="language">EN</a>
                                </li>
                                <li>
                                    <a href="#"><img src="/images/common/ru-flag.png" alt="language">RU</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                    <div class="top-search">
                            <form>
                                    <input type="text" name="text">
                                    <button><i class="fa fa-search" aria-hidden="true"></i></button>
                            </form>
                    </div>

                    <div class="clear"></div>
            </div>
        </div>
    </div>
</div>

    <!--MAIN MENU WRAP BEGIN-->
<div class="main-menu-wrap sticky-menu">
    <div class="container">
        <a href="index.html" class="custom-logo-link"><img src="/images/hockey/logo.png" alt="logo" class="custom-logo"></a>
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#team-menu" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <nav class="navbar">
            <div class="collapse navbar-collapse" id="team-menu">
                <ul class="main-menu nav">
                    <li class="<?=$this->context->route == 'site/index' ? 'active' : ''?>">
                        <a href="/"><span>Home</span></a>
                    </li>
                    <?php
                        if(Yii::$app->user->isGuest):
                    ?>
                        <li class="<?=$this->context->route == 'site/login' ? 'active' : ''?>">
                            <a href="/login"><span>Sign in</span></a>
                        </li>
                        <li class="<?=$this->context->route == 'site/register' ? 'active' : ''?>">
                            <a href="/register"><span>Sign up</span></a>
                        </li>
                    <?php
                        else:
                    ?>
                        <li>
                            <a href="/"><span>Hi, <?=Yii::$app->user->identity->username?></span></a>
                            <ul>
                                <li><a href="/profile/index"><span>My profile</span></a></li>
                                <li><a href="/logout"><span>Logout</span></a></li>
                            </ul>
                        </li>
                    <?php
                        endif;
                    ?>
                    <!--<li>
                        <a href="matches.html"><span>Matches</span></a>
                        <ul>
                            <li>
                                <a href="standing-cup.html"><span>Standings<i class="fa fa-long-arrow-right" aria-hidden="true"></i></span></a>
                                <ul>
                                    <li><a href="standings.html"><span>championship</span></a></li>
                                </ul>
                            </li>
                            <li><a href="club-stats.html"><span>club stats</span></a></li>
                            <li><a href="match-live.html"><span>match live</span></a></li>
                            <li><a href="broadcasts.html"><span>broadcasts</span></a></li>
                            <li><a href="upcoming-match.html"><span>upcoming match</span></a></li>
                            <li>
                                <a href="championships-archive.html"><span>championships archive<i class="fa fa-long-arrow-right" aria-hidden="true"></i></span></a>
                                <ul>
                                    <li><a href="championship.html"><span>championship information</span></a></li>
                                </ul>	
                            </li>
                            <li><a href="live-text-stream.html"><span>Text stream</span></a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="staff.html"><span>Team</span></a>
                        <ul>
                            <li><a href="player.html"><span>player first page</span></a></li>
                            <li><a href="player-second-page.html"><span>player second page</span></a></li>
                        </ul>
                    </li>
                    <li><a href="news.html"><span>News</span></a></li>
                    <li><a href="news-single.html"><span>News Single</span></a></li>
                    <li><a href="store.html"><span>Store</span></a></li>
                    <li><a href="contacts.html"><span>Contact</span></a></li>
                    <li>
                        <a href="#other"><span>other</span></a>
                        <ul>
                            <li><a href="404.html"><span>404</span></a></li>
                            <li><a href="offline.html"><span>offline</span></a></li>
                            <li><a href="coming-soon.html"><span>comming soon</span></a></li>
                            <li><a href="search.html"><span>search</span></a></li>
                            <li><a href="donations.html"><span>donations</span></a></li>
                            <li><a href="trophies.html"><span>trophies</span></a></li>
                            <li><a href="about-club.html"><span>about club</span></a></li>
                            <li><a href="checkout.html"><span>checkout</span></a></li>
                        </ul>
                    </li>-->
                    <!--<li class="cart full">
                        <a href="#cart">
                            <span><i class="fa fa-shopping-cart" aria-hidden="true"></i></span>
                        </a>
                        <div class="cart-drop">
                            <table class="ct">
                                <tr>
                                    <td class="delete"><a href="#"><i class="fa fa-close" aria-hidden="true"></i></a></td>
                                    <td class="info">
                                        <img class="product-image" src="images/common/cart-product.jpg" alt="product-image">
                                        <em>Men's T-Shirt<br><em class="price">1 x £ 60</em></em>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="delete"><a href="#"><i class="fa fa-close" aria-hidden="true"></i></a></td>
                                    <td class="info">
                                        <img class="product-image" src="images/common/cart-product.jpg" alt="product-image">
                                        <em>Men's T-Shirt<br><em class="price">1 x £ 60</em></em>
                                    </td>
                                </tr>
                            </table>
                            <div class="wrap">
                                <div class="total-text">Subtotal: </div>
                                <div class="total-digit">£ 120</div>
                            </div>
                            <div class="wrap btn-wrap">
                                <a href="cart.html" class="btn view">View cart</a>
                                <a href="checkout.html" class="btn check">checkout cart</a>
                            </div>
                        </div>
                    </li>-->
                </ul>
            </div>       
        </nav>
    </div>
</div>

    <?= Alert::widget() ?>
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
    <!--<div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-xs-6">
                    <div class="copyrights">
                        © 2017 Team - Sport club psd template
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="created">
                        <a href="#">Created by <img src="images/common/created-icon.png" alt="create-by-image"> torbara</a>
                    </div>
                </div>
            </div>
        </div>
    </div>-->
</footer>
<!--FOOTER END-->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
