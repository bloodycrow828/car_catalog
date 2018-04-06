<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '//fonts.googleapis.com/css?family=Open+Sans:400,400i,300,700',
        'css/bootstrap.css',
        'css/stylesheet.css',


        'css/animation.css',
        'css/slideshow.css',

        'css/pavreassurance.css',

        'css/pavnewsletter.css',

        'css/carousel.css',
    ];

    public $js = [
        'js/common.js',


    ];
    public $depends = [
        'frontend\assets\FontAwesomeAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
