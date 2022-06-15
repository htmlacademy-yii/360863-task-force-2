<?php

namespace app\assets;

use yii\web\YiiAsset;

class LandingAsset extends \yii\web\AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/normalize.css',
        'css/landing.css'
    ];

    public $js = [
        'js/landing.js',
    ];

    public $depends = [
        YiiAsset::class,
    ];

}