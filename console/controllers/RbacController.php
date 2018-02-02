<?php
namespace console\controllers;
use Yii;
use yii\console\Controller;

/**
 * Created by PhpStorm.
 * User: Hooman
 * Date: 11/1/2017
 * Time: 9:33 AM
 */
class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $admin = $auth->createRole('admin');
        $auth->add($admin);

        $auth->assign($admin, 1);


        $user = $auth->createRole('user');
        $auth->add($user);



    }

}