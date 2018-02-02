<?php
return [

    'modules' => [
        'display2'=> [
            'class'=>'pavlinter\display2\Module',
            'categories' => [
                'all' => [
                    'imagesWebDir' => '@imagesRoot/Album-images/originals',
                    'imagesDir' => '@imagesRoot/Album-images/originals',
                    'defaultWebDir' => '@imagesRoot/Album-images/default',
                    'defaultDir' => '@imagesRoot/Album-images/default',
                    'mode' => \pavlinter\display2\objects\Image::MODE_OUTBOUND,
                ],
            ],
        ],
    ],


    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'language'=>'fa',
    'name'=>'گالری',
    'version'=>'1.0.0',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'display' => [
            'class' => 'pavlinter\display2\components\Display',
            'resizeModes' => [
                'ownResizeMode' => 'pavlinter\display2\objects\ResizeMode',
                'ownResizeModeParams' => [
                    'class' => 'pavlinter\display2\objects\ResizeMode',
                ],
                'ownResizeModeFunc' => function ($image, $originalImage) {
                    /* @var $this \pavlinter\display2\components\Display */
                    /* @var $image \pavlinter\display2\objects\Image */
                    /* @var $originalImage \Imagine\Gd\Image */
                    return $originalImage->thumbnail(new \Imagine\Image\Box($image->width, $image->height), \pavlinter\display2\objects\Image::MODE_OUTBOUND);
                }
            ],
        ],
    ],



];
