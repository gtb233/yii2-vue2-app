<?php
/**
 * 身份认证
 * Date: 2018/4/13
 * Time: 15:50
 */

namespace app\controllers;


class AuthController extends BaseApiController
{
    public function actionIndex()
    {
        $username = \yii::$app->request->post('name');
        $password = \yii::$app->request->post('password');
        if ($username == 'admin' && $password == 'admin'){
            return ['success' => 1, 'msg' => '100-token'];
        }
        return ['success' => 0, 'msg' => \yii::t('app', 'username or password error!')];
    }
}