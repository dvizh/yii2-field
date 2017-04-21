<?php
namespace dvizh\field\assets;

use yii\web\AssetBundle;

class VariantsAsset extends AssetBundle
{
    public $depends = [
        'dvizh\field\assets\Asset'
    ];

    public $js = [
        'js/variants.js',
    ];

    public $css = [
        'css/variants.css',
    ];

    public function init()
    {
        $this->sourcePath = __DIR__ . '/../web';
        parent::init();
    }

}
