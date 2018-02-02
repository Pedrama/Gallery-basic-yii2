<?php

namespace backend\controllers;


use common\models\Album;
use Yii;
use common\models\Image;
use common\models\search\ImageSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ImageController implements the CRUD actions for Image model.
 */
class ImageController extends Controller
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
                            'create_image',
                            'uploadimage',
                            'imageadd',
                            'del',

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
    }

    /**
     * Lists all Image models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ImageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Image model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Image model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($albumId)
    {
        $model = new Image();
//        $request = Yii::$app->request;
//        $get = $request->get("albumId", null);
        $model->album_id = $albumId;
        if ($model->parentAlbum()->one()) {
            Yii::$app->session->setFlash('danger', 'این آلبوم دارای زیر آلبوم می باشد. نمی توانید تصویر اضافه کنید');
            return $this->redirect(['album/index']);
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($model->album->cover_image_id == 0) {
                $model->album->cover_image_id = $model->id;
                $model->album->save();
                Yii::$app->session->setFlash('success', 'تصویر به آلبوم اضافه شد و به عنوان عکس کاور مشخص گردید.');

            } else {
                Yii::$app->session->setFlash('success', 'تصویر به آلبوم اضافه شد.');
            }

            return $this->redirect(['album/index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Image model.
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
     * Deletes an existing Image model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDel($id, $url)
    {
        $model = Image::findOne($id);


        if ( $model->albums) {
            Yii::$app->session->setFlash("danger", "این عکس به عنوان عکس کاور می باشد نمی توان حذف نمود");
        } elseif (Image::findOne($id)->delete()) {
            Yii::$app->session->setFlash("seccess", "حذف عکس با موفقیت انجام شد");
        } else {
            Yii::$app->session->setFlash("danger", "حذف عکس انجام نشد");
        }
        return $this->redirect($url);
    }

    /**
     * Finds the Image model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Image the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Image::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    //***********************************

    /**
     * @param $postId
     * @return array|string
     */

    public function actionImageadd()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = new Image();
        $file = UploadedFile::getInstance($model, 'image_tmp_name');
        if (empty($file)) {
            $model->addError('name', Yii::t('app', 'فایل یافت نشد'));
            Yii::$app->end();
        }
        $extArray = explode('.', $file->name);
        $ext = strtolower(end($extArray));
        if (!in_array($ext, Image::$validExtImageUpload) || $file->size > Image::$maxUploadImageSize) {
            $model->addError('name', Yii::t('app', 'فایل مجاز نیست'));
            return [
                'response' => false,
                'extra' => [
                    'error' => 'فرمت فایل مجاز نمی باشد',
                ]
            ];
            Yii::$app->end();
        }
        $fileName = time() . '-' . $file->name;
        $path = Yii::getAlias('@imagesRoot') . '/Album-images/originals/' . $fileName;
        if ($file->saveAs($path)) {
            return [
                'response' => true,
                'extra' => [
                    'fileName' => $fileName,
                ]
            ];
        }
        return false;
    }


}
