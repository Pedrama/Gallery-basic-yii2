<?php

namespace backend\controllers;


use backend\components\Controller;

use common\models\Image;
use Yii;
use common\models\Album;
use common\models\search\AlbumSearch;
use yii\filters\AccessControl;


use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
//use yii\web\Response;
use yii\web\UploadedFile;

/**
 * AlbumController implements the CRUD actions for Album model.
 */
class AlbumController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [
                            'create',
                            'view',
                            'index',
                            'update',
                            'delete',
                            'sub_album',
                            'del',


//
                        ],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
        /*****************************************
         *
         */

    }


    /**
     * Lists all Album models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AlbumSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Album model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        }
        return $this->render('view', [
            'model' => $model,

        ]);
    }


    /**
     * Creates a new Album model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Album();

        if ($model->load(Yii::$app->request->post())&&$model->save()) {
//            ye model baray serach to image baray barresi vojode image baray album ast
            if (!empty($model->parent2)) {
                $i = 0;//faghat baray namash tedad enteghl mibashad
                foreach ($model->parent2 as $item) {
                    $i++;
//                    agar avali bashad avalin aks ro ham cover image mikone
                    if ($i == 1) {
                        $model->cover_image_id = $item['id'];
                       $model->save();
                    }
                    $item['album_id']=$model->id;//taghir id album
                    $item->save();

                }
                //msg baray namash payam
                $msg="زیر آلبوم جدید ایجاد و تعداد ".$i."عکس از آلبوم اصلی به آن منتقل گردید.";
                Yii::$app->session->setFlash('success',$msg );
            }elseif ($model->parent_id>0){
                Yii::$app->session->setFlash('success', 'زیر آلبوم جدبد ایجاد شد .');
            }
            else {
                // dar sorati ke zir album aks nadarad
                Yii::$app->session->setFlash('success', 'آلبوم جدبد ایجاد شد .');
            }

         return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Album model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Album model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        Yii::$app->session->setFlash('success', 'عملیات حذف با موفقیت انجام شد.');
        return $this->redirect(['index']);

    }


    public function actionDel($id)
    {
        //  $request = Yii::$app->request;
//        $get = $request->get("albumId", null);

        $model = $this->findModel($id);
        //tashkhis zir album
        if (Album::findOne(['parent_id' => $model->id])) {
            Yii::$app->session->setFlash('danger', 'برای حذف این آلبوم ابتدا زیر آلبوم های آن را حذف نمائید.');
            return $this->redirect(['album/index']);
        }
        //tashkhis aks
        if (Image::findOne(['album_id' => $model->id])) {
            Yii::$app->session->setFlash('danger', 'برای حذف این آلبوم ابتدا عکس های آن را حذف نمائید.');
            return $this->redirect(['album/index']);
        }
        return $this->render('del', [
            'model' => $model,
            'id' => $model->id,
        ]);


    }

    /**
     * Finds the Album model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Album the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Album::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionSub_album($parentId)
    {
        $query = Album::find()->where(['parent_id' => $parentId]);
        return $this->render('sub_album', ['model' => $query,]);

    }


}
