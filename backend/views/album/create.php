<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Album */

$this->title = 'Create Album';
$this->params['breadcrumbs'][] = ['label' => 'Albums', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="album-create">

    <h1>ایجاد آلبوم</h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
