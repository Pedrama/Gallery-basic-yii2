<?php

use common\models\Album;
use common\models\Image;
use common\models\Like;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model common\models\Album */

$this->title = "test";
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
    .commenticon{
        color: #0c5460;
        font-size: 40px;
        text-decoration: none;

    }
    .myIcon {
        color: #0c5460;
        font-size: 40px;
text-decoration: none;
    }


</style>
<div class="album-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="container ">


        <?php if (Album::find()->where(['parent_id' => $id])->exists()): ?>
            <?php $model = Album::find()->where(['parent_id' => $id])->all(); ?>
            <?php foreach ($model as $subAlbum): ?>
                <?php if (!empty($subAlbum['cover_image_id'])): ?>
                    <?php $query = Image::find()->where(['id' => $subAlbum['cover_image_id']])->one(); ?>
                    <?php $filename = $query['name']; ?>
                    <?php $path = domain . 'gallery/images/Album-images/originals/' . $filename; ?>
                <?php else: ?>
                    <?php $filename = 'noImage.png' ?>
                    <?php $path = domain . 'gallery/images/' . $filename; ?>
                <?php endif; ?>
                <div class="mydivgallery">

                    <a href="<?= Yii::$app->urlManager->createUrl(['album/view', 'id' => $subAlbum['id']]) ?>">
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
            <?php $query = Image::find()->where(['album_id' => $id])->all() ?>
            <?php if (!empty($query)): ?>

                <?php $form = ActiveForm::begin() ?>

                <?php foreach ($query as $item): ?>
                    <?= "<div class='mydivgallery'>" ?>

                    <a href="<?= Yii::$app->urlManager->createUrl(['album/view_image',
                        'id' => $item['id'],
                    ]) ?>" target="_blank">
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


                    <?= Like::find()->where(['image_id' => $item['id']])->count(); ?>
                    <?php if (Like::find()->where(['image_id' => $item['id']])->andWhere(['create_user_id' => Yii::$app->user->id])->exists()): ?>
                        <a style="color:red;" class="myIcon glyphicon glyphicon-heart"
                           href="<?= Yii::$app->urlManager->createUrl(['like/create',
                               'id' => $item['id'],
                               'url' => Yii::$app->request->url,
                           ]) ?>"></a>

                    <?php else: ?>
                        <a class="myIcon glyphicon glyphicon-heart"
                           href="<?= Yii::$app->urlManager->createUrl(['like/create',
                               'id' => $item['id'],
                               'url' => Yii::$app->request->url,
                           ]) ?>"></a>

                    <?php endif; ?>
                    <a class="commenticon glyphicon glyphicon-comment" href="<?= Yii::$app->urlManager->createUrl(['album/view_image','id' => $item['id'] ]) ?>"></a>

                    <?= '</div>' ?>
                <?php endforeach; ?>
                <?php ActiveForm::end(); ?>
            <?php else: ?>
                <?= 'تصویری موجود نیست لطفا تصویر اضافه کنید ' ?>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
