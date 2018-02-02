<?php
namespace frontend\controllers;

use common\models\Like;
use Yii;
use yii\web\Controller;

/**
 * Created by PhpStorm.
 * User: Pedram
 * Date: 04/12/2017
 * Time: 01:45 PM
 */
class LikeController extends Controller
{
    public function actionCreate($id, $url)
    {
        if (Yii::$app->user->getIsGuest()) {
            Yii::$app->session->setFlash('danger', 'برای ثبت علاقه مندی ابتدای وارد شوید.');
            return $this->redirect(Yii::$app->urlManager->createUrl(['site/login']));
        } else {
            if (Like::find()->where(['image_id' => $id])->andWhere(['create_user_id' => Yii::$app->user->id])->exists()) {
                if (Like::find()->where(['image_id' => $id])->one()->delete()) {
                    Yii::$app->session->setFlash('success', 'نظر شما با موفقیت ثبت شد ');
                    return $this->redirect($url);
                } else {
                    Yii::$app->session->setFlash('danger', 'نظر شما با ثبت نشد ');
                    return $this->redirect($url);
                }

            } else {
                $like = new Like();
                $like->image_id = $id;
                if ($like->save()) {
                    Yii::$app->session->setFlash('success', 'نظر شما با موفقیت ثبت شد ');
                    return $this->redirect($url);
                } else {
                    Yii::$app->session->setFlash('danger', 'نظر شما با ثبت نشد ');
                    return $this->redirect($url);
                }
            }
        }
    }
}

?>

