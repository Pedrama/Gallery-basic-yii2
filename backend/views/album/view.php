<?php

use common\models\Album;
use common\models\Image;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model common\models\Album */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Albums', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">

    .myimage {
        width: 250px;
        height: 250px;
        border-radius: 5px;

    }

    .mydivgallery {
        float: right;
        text-align: center;
        margin: 10px;
    }

    .myimagesubalbum {
        width: 100px;
        height: 100px;
        border-radius: 50%;
    }
</style>
<div class="album-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="container ">
        <?php if (!empty($model->albums)): ?>
            <?php foreach ($model->albums as $subAlbum): ?>
                <?php if (!empty($subAlbum['cover_image_id'])): ?>
                    <?php $query = Image::find()->where(['id' => $subAlbum['cover_image_id']])->one(); ?>
                    <?php $filename = $query['name']; ?>
                    <?php $path = domain . 'gallery/images/Album-images/originals/' . $filename; ?>
                <?php else: ?>
                    <?php $filename = 'noImage.png' ?>
                    <?php $path = domain . 'gallery/images/' . $filename; ?>
                <?php endif; ?>
                <div class="mydivgallery">
                    <a href="<?= domain . 'gallery/backend/album/view?id=' . $subAlbum['id'] ?>">
                        <lable><?= $subAlbum['name']; ?></lable>
                        <br/>


                        <?php echo Yii::$app->display->showCropImage([ //subfolders image
                            'width' => 120,
                            'image' => $filename, // or subfolders/bg.jpg
                            'category' => 'all',
                            'options' => [
                                'class' => 'myimagesubalbum',
                            ]
                        ]); ?>


                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
        <?php $query = Image::find()->where(['album_id' => $model->id])->all() ?>

        <?php if (!empty($query)): ?>
        <?php ActiveForm::begin() ?>

                <?php foreach ($query as $item): ?>
   <div class='mydivgallery'>
    <a href="<?= domain . 'gallery/images/Album-images/originals/' . $item['name'] ?>" target="_blank">

        <?php echo Yii::$app->display->showCropImage([ //subfolders image
            'width' => 120,
            'image' => $item['name'], // or subfolders/bg.jpg
            'category' => 'all',
            'options' => [
                'class' => 'myimage',
            ]
        ]); ?>
    </a>
    <br/>
    <?= Html::input('radio', 'Album[cover_image_id]', $item['id']) ?>

     <?=  Html::a('<span style="color:red;" class="glyphicon glyphicon-trash"></span>',['image/del',
         'id'=>$item['id'],
         'url'=>Yii::$app->request->url,
         ]) ?>
     </div>
    <?php endforeach; ?>
    <div style="clear: both">
        <input type="submit" value="انتخاب" class="btn btn-primary">
    </div>
    <?php ActiveForm::end() ?>
    <?php else: ?>
        <?= 'تصویری موجود نیست لطفا تصویر اضافه کنید ' ?>
    <?php endif; ?>
    <?php endif; ?>
</div>
</div>