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
class BackendAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        "backend/vendor/metisMenu/metisMenu.min.css",
        "backend/dist/css/sb-admin-2.css",
        "backend/vendor/font-awesome/css/font-awesome.min.css",
    ];
    public $js = [
        "backend/vendor/metisMenu/metisMenu.min.js",
        "backend/dist/js/sb-admin-2.js",
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
