<?php

use common\models\Album;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Image */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="image-form">
    <?php

    ?>
    <?php $form = ActiveForm::begin(); ?>

    <!--اکتنشن Katrik-v بارگذاری تصویر-->
    <?php
    echo FileInput::widget([
        'name' => 'Image[image_tmp_name]',
        'options' => [
            'id'=>'upload-post-pic',
            'multiple' => false
        ],
        'pluginOptions' => [
            'uploadUrl' => Url::to(['imageadd']),
        ],
        'pluginEvents'=>[
            "filebatchselected"=>"function(event,files){
                $('#upload-post-pic').fileinput('upload');
                }",
            "fileuploaded"=>"function(event,data,previewId,index){
                                var from=data.from,files=data.files,extra=data.extra,
                                response=data.response,reader=data.reader;
                                $('#'+previewId).append('<input type=\"hidden\"name=\"Image[name]\"value=\"'+response.extra.fileName+'\"/>');
                                $('#'+previewId+'.progress').hide();
         }",
        ]
    ]);
    ?>



    <input type="hidden" id="image-album_id" class="form-control" name="Image[album_id]" value="<?=$model->album_id?>" maxlength>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
