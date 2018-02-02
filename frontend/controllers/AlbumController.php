<?php
/**
 * Created by PhpStorm.
 * User: Pedram
 * Date: 04/12/2017
 * Time: 10:26 AM
 */

namespace frontend\controllers;


use common\models\Album;
use common\models\Comment;
use common\models\Image;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class AlbumController extends Controller
{
    public function actionView($id)
    {
        $model = new Album();

        return $this->render('view', [
            'model' => $model,
            'id' => $id,

        ]);
    }

    public function actionView_image($id)
    {
        if (!Yii::$app->user->getIsGuest()) {
            $image = Image::findOne($id);
            if ($image == null) {
                throw new NotFoundHttpException();
            }
            $commentModel = new Comment();
            $commentModel->image_id = $image->id;
            return $this->render('view_image', [
                'image' => $image,
                'commentModel' => $commentModel,
            ]);
        }
else{
      Yii::$app->session->setFlash('danger','برای ارسال نظر ابتدا وارد شود ');
      return $this->redirect(Yii::$app->urlManager->createUrl(['site/login']));
}
    }

}