<?php
/**
 * Created by PhpStorm.
 * User: Pedram
 * Date: 02/12/2017
 * Time: 02:09 PM
 */


use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Album;

?>
<h1><?= Html::encode($this->title) ?></h1>


<h1> حذف</h1>
<?php ActiveForm::begin([

    'action'=>'delete?id='.$model->id,
])?>

<input type="hidden" name="id" value="<?=$model->id?>"/>
<h5>آیا مطمئن هستید آلبوم  <?= $model->name; ?> حذف شود ؟</h5>
<?= Html::input('submit',null,'حذف',[
        'class'=>'btn btn-danger',
        ])?>
<?= Html::a('انصراف','index',['class'=>'btn btn-success'])?>
<?php ActiveForm::end() ?>

