<?php
define("domain","http://localhost:8080/");
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@imagesRoot', dirname(dirname(__DIR__)) .DIRECTORY_SEPARATOR. 'images');

