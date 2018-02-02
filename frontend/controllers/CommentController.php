<?php
/**
 * Created by PhpStorm.
 * User: Pedram
 * Date: 04/12/2017
 * Time: 09:46 AM
 */

namespace frontend\controllers;


use common\models\Comment;
use Yii;
use yii\web\Controller;

class CommentController extends Controller
{
    public function actionCreate(){
        $model = new Comment();
        if($model->load(Yii::$app->request->post()) && $model->save()){
            Yii::$app->session->setFlash('success','نظر شما با موفقیت ثبت شد و پس از تایید نمایش داده خواهد شد.');
            return $this->redirect(['site/index']);
        }else{
            return $this->goBack();
        }
    }
}