<?php
/**
 * Created by PhpStorm.
 * User: Pedram
 * Date: 05/12/2017
 * Time: 01:13 PM
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<?php $form = ActiveForm::begin() ?>

<?php foreach ($query as $item): ?>
    <?= "<div class='mydivgallery'>" ?>
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
    <!--                    <input type="radio" name="Album[cover_image_id]" value="--><//= $item['id'] ?><!--"/>-->
    <?= Html::input('radio','Album[cover_image_id]',$item['id']) ?>
    <?= '</div>' ?>
<?php endforeach; ?>
<div style="clear: both">
    <input type="submit" value="انتخاب" class="btn btn-primary">
</div>
<?php ActiveForm::end(); ?>
