<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


use yii\helpers\Json;
use common\models\SysUtils;
use frontend\models\UserService;
use frontend\models\TradeService;


/**
 * 交易管理
 */
class TradeController extends Controller
{
     /**
     * 发放游戏房卡或金币
     *
     * @return array
     */
    public function actionDonate(){

        $toUserGameId = $_GET['gameid'];
        $qty = $_GET['qty'];

        return Json::encode(['retcode'=>0]);
    }
     /**
     * 返回赠送数据，并且用isLastPage表示是否是最后一页;
     *
     * @return array
     */  
    public function actionToDonateItems(){
        $rep = [];
        $unionId = SysUtils::getValueByCacheKey('unionid');
        $unionId = 'fsdfndsfnlas2342342424242';
        if(!$unionId){
            $rep= [
                'retcode' => 0,
                'retmsg' => '身份信息已过期'
            ];
            return json_encode($rep);

        }
        //初始化分页参数;
    	$page   = isset($_GET['page'])?$_GET['page']:1;
        $offset = isset($_GET['offset'])?$_GET['offset']:10;
        //获取用户ID
        $user = UserService::searchUserFromBackend($unionId);
        if(empty($user)){
            $rep= [
                'retcode' => 1,
                'retmsg' => '用户不存在'
            ];
            return json_encode($rep);

        }
        $curUserId = $user['userid'];
        $cnt = TradeService::getDonateItemsCount($curUserId);
        $rows = TradeService::getDonateItemsByPage($curUserId,$page,$offset);
        $lastPage = false;
        if($page*$offset>=$cnt){
            $isLast = true;
        }
        $rep = ['isLastPage'=>$isLast,'data'=>$rows];
        return json_encode($rep);
    }

    public function actionAccpetItems(){ 
        $rep = [];
        $unionId = SysUtils::getValueByCacheKey('unionid');
        $unionId = 'fsdfndsfnlas2342342424242';
        if(!$unionId){
            $rep= [
                'retcode' => 0,
                'retmsg' => '身份信息已过期'
            ];
            return json_encode($rep);

        }
         //初始化分页参数;
        $page   = isset($_GET['page'])?$_GET['page']:1;
        $offset = isset($_GET['offset'])?$_GET['offset']:10;
        //获取用户ID
        $user = UserService::searchUserFromBackend($unionId);
        if(empty($user)){
            $rep= [
                'retcode' => 1,
                'retmsg' => '用户不存在'
            ];
            return json_encode($rep);

        }
        $curUserId = $user['userid'];
        $cnt = TradeService::getAcceptItemsCount($curUserId);
        $rows = TradeService::getAcceptItemsByPage($curUserId,$page,$offset);
        $lastPage = false;
        if($page*$offset>=$cnt){
            $isLast = true;
        }
        $rep = ['isLastPage'=>$isLast,'data'=>$rows];
        return json_encode($rep);

    }

    
}
