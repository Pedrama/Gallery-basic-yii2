<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $searchModel common\models\search\AlbumSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Albums';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="album-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Album', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'parent_id',
            'cover_image_id',
            'create_user_id',
            // 'update_user_id',
            // 'created_at',
            // 'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}{del}{image}',
                'buttons' => [
                    'del' => function ($url, $model, $key) {
                        return Html::a(
                            '<span style="color:red;" class="glyphicon glyphicon-trash"></span>',
                            ['del', 'id' => $model->id]);

                    }
                    ,
                    'image' => function ($url, $model, $key) {

                        return Html::a(
                            '<span style="color:green;" class="glyphicon glyphicon-camera"></span>',
                            ['image/create', 'albumId' => $model->id]
                        );

                    }
                ]


            ],

        ],
    ]);

    ?>
    <?php Pjax::end(); ?></div>
