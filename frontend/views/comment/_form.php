<?php
/**
 * Created by PhpStorm.
 * User: Pedram
 * Date: 04/12/2017
 * Time: 10:44 AM
 */

?>
<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<div class="row">
    <?php $form = ActiveForm::begin([
        'id' => 'comment-form',
        'action' => ['comment/create'],
    ]) ?>

<!--    <//= $form->field($commentModel,'image_id')->hiddenInput() >-->
    <input type="hidden" id="comment-image_id" class="form-control" name="Comment[image_id]" value="<?=$commentModel->image_id?>"/>
    <?= $form->field($commentModel,'content')->textarea() ?>
    <?= Html::submitButton('ارسال'); ?>
    <?php ActiveForm::end(); ?>
</div>
