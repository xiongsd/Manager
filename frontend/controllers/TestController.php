<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


use yii\helpers\Json;
use frontend\models\UserModel;


/**
 * 测试
 */
class TestController extends Controller
{
   public function actionReg(){
        $userModel = new UserModel();
        $userModel->username = "熊少弟";
        $userModel->telephone = "13970912972";
        $userModel->nickname ="fsdfsd";
        $userModel->sex = 1;
        $userModel->markid = "fsdfndsfnlas2342342424242";
        $userModel->create_at = date('Y-m-d H:i:s');
        $userModel->last_login = date('Y-m-d H:i:s');
        $userModel->status = 0;//未启用状态;
        if($userModel->validate()){
            if($userModel->save()){
                return json_encode(['retcode'=>0,'msg'=>'注册成功']);
            }else{
                return json_encode(['retcode'=>6,'msg'=>'其它异常']);
            }
        }else{
            return json_encode(['retcode'=>5,'msg'=>$userModel->errors]);

        }
   }

}
