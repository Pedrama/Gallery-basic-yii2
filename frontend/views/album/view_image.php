<?php
/**
 * Created by PhpStorm.
 * User: Pedram
 * Date: 04/12/2017
 * Time: 10:34 AM
 */


?>

<div class="one-post ">
    <div class="center text-center">
        <h1><?= $image->name ?></h1>

        <?php if (!empty($image->name)): ?>
            <?php echo Yii::$app->display->showCropImage([ //subfolders image
                'width' => 350,
                'image' => $image->name, // or subfolders/bg.jpg
                'category' => 'all',
                'options' => [
                    'class' => 'myimagesubalbum ',
                ]
            ]); ?>
        <?php endif; ?>
        <div>
            <?= date('Y/m/d', $image->created_at); ?>
        </div>
    </div>
    <div id="comments">
        <label>نظرات : </label>
        <br/>
        <?php foreach ($image->comments as $comment): ?>
            <pre>
           <?= $comment->content; ?>
            </pre>
            <br/>
        <?php endforeach; ?>
    </div>

    <?= $this->render('//comment/_form', ['commentModel' => $commentModel]); ?>
</div>
