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
        '//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css',
        'css/app.css',
    ];
    public $js = [
        // 'js/fontawesome.js',
        'js/fonts.js',
        'js/app.js'
    ];
    public $depends = [
  
    ];
}
