<?php
namespace dvizh\field;

use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        if(empty($app->modules['gridview'])) {
            $app->setModule('gridview', [
                'class' => '\kartik\grid\Module',
            ]);
        }
    }
}