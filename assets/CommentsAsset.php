<?php

namespace qvalent\comments\assets;

use yii\web\AssetBundle;

class CommentsAsset extends AssetBundle
{
    public $sourcePath = '@qvalent/comments/assets/resources';
    public $css = [
        'style.css'
    ];
    public $js = [
        'comments.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'backend\assets\FontAwesomeAsset'
    ];
}
