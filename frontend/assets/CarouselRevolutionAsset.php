<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class CarouselRevolutionAsset extends AssetBundle
{
    public $sourcePath = '@bloodycrow828/SliderRevolution/src';
    public $css = [
        'css/settings.css',
        'css/settings-ie8.css',
    ];
    public $js = [
        'js/jquery.themepunch.plugins.min.js',
        'js/jquery.themepunch.revolution.js',
    ];
    public $cssOptions = [
        'media' => 'screen',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
