<?php

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;

class CustomeTheme extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    //public $jsOptions = ['position' => View::POS_HEAD];
    public $css = [
        'css/metisMenu/metisMenu.min.css',
        'css/sb-admin-2.min.css',
        'https://fonts.googleapis.com/css?family=Roboto:300,400',
    ];
    public $js = [
        'js/metisMenu/metisMenu.min.js',
        'js/sb-admin-2.js',
        'js/app.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
