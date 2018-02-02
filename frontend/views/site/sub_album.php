<?php
use yii\db\Query;
use yii\helpers\Html;
?>


<h1><?= Html::encode($this->title) ?></h1>

<?php
//echo "<pre>";print_r($model);
foreach ($model as $item) {

    if (!isset($item['parent_id'])){
        if (isset($item['cover_image_id'])) {
//            $query = (new Query())->select(['name',])->from('tbl_image')->where('id' == $item['cover_image_id'])->one();
            $query=\common\models\Image::find()->where(['id'=>$item['cover_image_id']])->one();
            $path = domain . 'gallery/images/Album-images/originals/' . $query['name'];
            echo "<div style=\"float: right; margin:  10px 10px;\">";

            echo Html::img($path, ['width' => '150', 'height' => '150', 'class' => 'myimg']);
            echo "<br/>";
            echo Html::a(
                $item['name'],
                ['sub_album', 'parentId' => $item['id']]
            );
            echo "</div>";
        } else {
            $path = domain . 'gallery/images/noImage.png';
            echo "<div style=\"float: right; margin:  10px 10px;\">";
            echo Html::img($path, ['width' => '150', 'height' => '150', 'class' => 'myimg']);

            echo "<br/>";
            echo Html::a(
                $item['name'],
                ['create_image', 'parentId' => $item['id']]
            );

            echo "</div>";
        }
}else{
       // die("ghgfh");
    }

}
?>
