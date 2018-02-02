<?php


use common\models\Image;
use common\models\Album;
use yii\db\Query;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

?>

<style type="text/css">
    .myimg {
        border-radius: 100%;

    }

    body {
        direction: rtl;
        text-align: center;

    }

</style>

<h1>به گالری تصاویر خوش آمدید ...</h1>

<div class="image-index">


    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <!--        <ol class="carousel-indicators">-->
        <!--            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>-->
        <!--            <li data-target="#myCarousel" data-slide-to="1"></li>-->
        <!--            <li data-target="#myCarousel" data-slide-to="2"></li>-->
        <!--        </ol>-->

        <!-- Wrapper for slides -->
        <?php $myimg = Image::find()->all(); ?>
        <?php $count = 0; ?>
        <?php foreach ($myimg

        as $item): ?>
        <?php if ($count == 0): ?>
        <div class="carousel-inner" role="listbox">
            <div class="item active">
                <img src="http://localhost:8080/gallery/images/album-images/originals/<?= $item['name'] ?>"
                     alt="New York" width="1200" height="400" style="-webkit-background-size: cover">
                <div class="carousel-caption">
                    <h3>New York</h3>
                    <p>The atmosphere in New York is lorem ipsum.</p>
                </div>
            </div>
            <?php else: ?>
                <div class="item">
                    <img src="http://localhost:8080/gallery/images/album-images/originals/<?= $item['name'] ?>"
                         alt="Chicago" width="1200" height="400" style="-webkit-background-size: cover">
                    <div class="carousel-caption">
                        <h3>Chicago</h3>
                        <p>Thank you, Chicago - A night we won't forget.</p>
                    </div>
                </div>
            <?php endif; ?>
            <?php $count++; ?>
            <?php endforeach; ?>
            <div class="item">
                <img src="http://localhost:8080/gallery/images/noimage.png" alt="Chicago" width="1200" height="700">
                <div class="carousel-caption">
                    <h3>Chicago</h3>
                    <p>Thank you, Chicago - A night we won't forget.</p>
                </div>
            </div>

            <div class="item">
                <img src="http://localhost:8080/gallery/images/noimage.png" alt="Los Angeles" width="1200" height="700">
                <div class="carousel-caption">
                    <h3>LA</h3>
                    <p>Even though the traffic was a mess, we had the best time playing at Venice Beach!</p>
                </div>
            </div>
        </div>

        <!-- Left and right controls -->
        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <!--    --><?php
    //    $myimg=Image::find()->all();
    //    $myalbum=[];
    //    foreach ($myimg as $item){
    //        $mypath=domain . 'gallery/images/Album-images/originals/'.$item['name'];
    //        echo $mypath."<br>";
    //
    //        array_push($myalbum,$mypath);
    //    }
    //    echo "*****************";
    //    foreach ($myalbum as $item){
    //
    //        echo $item."<br>";
    //
    //    }
    //    $this->widget('ext.slider.slider', array(
    //            'container'=>'slideshow',
    //            'width'=>960,
    //            'height'=>240,
    //            'timeout'=>6000,
    //            'infos'=>true,
    //            'constrainImage'=>true,
    //            'images'=>array('http://localhost:8080/gallery/images/Album-images/originals/1511530724-persian gulf.jpg',
    //                'http://localhost:8080/gallery/images/Album-images/originals/1511674971-d.jpg',
    //                'http://localhost:8080/gallery/images/Album-images/originals/1511676428-iran.jpg'),
    //
    //            'alts'=>array('First description','Second description','Third description','Four description'),
    //'defaultUrl'=>'http://localhost:8080/gallery/images/Album-images/originals/'
    //        )
    //    );
    //    ?>

    <div class="container ">

        <?php foreach ($model as $item): ?>
            <?php if (!empty($item['cover_image_id'])): ?>
                <?php $query = Image::find()->where(['id' => $item['cover_image_id']])->one(); ?>
                <?php $filename = $query['name']; ?>
                <?php $path = domain . 'gallery/images/Album-images/originals/' . $filename; ?>
            <?php else: ?>
                <?php $filename = 'noImage.png' ?>
                <?php $path = domain . 'gallery/images/' . $filename; ?>
            <?php endif; ?>
            <div class="mydivgallery">

                <a href="<?= Yii::$app->urlManager->createUrl(['album/view', 'id' => $item['id']]) ?>">
                    <lable><?= $item['name']; ?></lable>
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

    </div>
</div>



