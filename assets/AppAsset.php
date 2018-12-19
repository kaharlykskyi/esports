<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/style.min.css',
        'css/site.css',
        'css/search-bar.css',
        'bracket/jquery.bracket.min.css',
    ];
    public $js = [
        'js/library/jquery-ui.js',
        'js/library/jquery.sticky.js',
        'js/library/jquery.jcarousel.js',
        'js/library/jcarousel.connected-carousels.js',
        'js/library/owl.carousel.js',
        'js/library/progressbar.js',
        'bracket/jquery.bracket.min.js',
        'js/library/chartist.js',
        'js/library/Chart.js',
        'js/library/fancySelect.js',
        'js/library/isotope.pkgd.js',
        'js/library/imagesloaded.pkgd.js',
        'js/jquery.team-coundown.js',
        'js/matches-slider.js',
        'js/header.js',
        'js/matches_broadcast_listing.js',
        'js/news-line.js',
        'js/match_galery.js',
        'js/main-club-gallery.js',
        'js/product-slider.js',
        'js/circle-bar.js',
        'js/standings.js',
        'js/shop-price-filter.js',
        'js/timeseries.js',
        'js/radar.js',
        'js/slider.js',
        'js/preloader.js',
        'js/diagram.js',
        'js/bi-polar-diagram.js',
        'js/label-placement-diagram.js',
        'js/donut-chart.js',
        'js/animate-donut.js',
        'js/advanced-smil.js',
        'js/svg-path.js',
        'js/pick-circle.js',
        'js/horizontal-bar.js',
        'js/gauge-chart.js',
        'js/stacked-bar.js',
        'js/library/chartist-plugin-legend.js',
        'js/library/chartist-plugin-threshold.js',
        'js/library/chartist-plugin-pointlabels.js',
        'js/treshold.js',
        'js/visible.js',
        'js/anchor.js',
        'js/landing_carousel.js',
        'js/landing_sport_standings.js',
        'js/twitterslider.js',
        'js/champions.js',
        'js/landing_mainnews_slider.js',
        'js/carousel.js',
        'js/video_slider.js',
        'js/footer_slides.js',
        'js/player_test.js',
        'js/main.js',
        'dropify/dist/js/dropify.js',
        'js/search-bar.js',
        'js/message.js',

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
