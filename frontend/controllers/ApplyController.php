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
use frontend\models\UserModel;
use frontend\models\ApplyService;
use frontend\models\SysService;

use common\models\SmsSingleSender;


/**
 * 代理商申请与查询
 */
class ApplyController extends Controller
{
    /**
     * 入申请页面进
     *
     * @return mixed
     */
    public function actionGoApply($markid)
    {


        $user = UserService::searchUserFromBackend($markid);
        $user = null;
        if($user === null){            
            return $this->render("apply_step1",['title'=>'申请与查询']);
        }else{
            $auditMsg = '';
            $statu=ApplyService::getAuditStatus(1);
            $status = 1;
            if($statu==1){
                return $this->index();                
            }elseif($statu==2){
                $auditMsg = '审核中';
                return $this->goAuditPage($auditMsg);
            }elseif($statu==0){
                $auditMsg = '待审核';
                return $this->goAuditPage($auditMsg);
            }else{
                $auditMsg = '审核失败';
                return $this->goAuditPage($auditMsg);
            }
        }
    } 
     /**
     * 进入主页
     *
     * @return mixed
     */
    private function index(){
        return $this->render('index');
    }
    public function goAuditPage($msg){
        $title = "提示信息";
        return $this->render('auditmsgpage',['auditmsg'=>$msg,'title'=>$title]);
    }

	    /**
     * 进入申请第二步，获取用户unionid，游戏ID；
     *
     * @return mixed
     */
    public function actionGoApplyStep2()
    {
        if(isset($_GET['gameid'])){
            $gameId = $_GET['gameid'];
        }
        $unionid = SysUtils::getValueByCacheKey('unionid');
        $isRegistered = 0;
        if($unionid!==false){
            $gameUserInfo = UserService::getUserInfoOnGamePlatform(); 
            $isRegistered = 1;
        }

        $title = '申请与查询';
        return $this->render('apply_step2',['gameId'=>$gameId,'title'=>$title,'isRegistered'=>$isRegistered]);
       
    }
     /**
     * 注册功能
     * 
     * @return json
     */    
    public function actionRegister(){
        $unionid = SysUtils::getValueBySessionKey('unionid');
        $unionid = "fsdfndsfnlas2342342424242";
        if($unionid!==false){
            return json_encode(['retcode'=>1,'msg'=>'认证信息已过期，请重新进入']);
        }
        //验证码
        if(!isset($_GET['verfiytelcode'])&&!empty($_GET['verfiytelcode'])){
             $verfiyTelCode = $_GET['verfiytelcode'];
        }else{
            throw new \Exception("验证码参数提交不合法!");
        }
       
        //手机号码
        if(!isset($_GET['tel'])&&!empty($_GET['tel'])){
             $tel = $_GET['tel'];
        }else{
            throw new \Exception("手机号码参数提交不合法!");
        }
        //姓名
        if(!isset($_GET['nickname'])&&!empty($_GET['nickname'])){
             $nickname = $_GET['nickname'];
        }else{
            throw new \Exception("昵称参数提交不合法!");
        }
        //核对是否已经注册
        $isRegistered = UserService::checkIsRegister($unionid);
        if($isRegistered){
            return json_encode(['retcode'=>4,'msg'=>'已经注册过，请联系客服']);
        }
        //核对验证码
        $isSuccess = UserService::checkAuthVerify($tel,$verfiyTelCode);
        if($isSuccess===false){
            return json_encode(['retcode'=>3,'msg'=>'验证码错误']);
        }


        //从游戏服务器获取用户信息
        $gameUserInfo = UserService::getUserInfoOnGamePlatform(); 
        $userModel = new UserModel();
        $userModel->telephone = $tel;
        $userModel->nickname = $nickName;
        $userModel->sex = $gameUserInfo['sex'];
        $userModel->markid = $unionid;
        $userModel->create_at = date('Y-m-d H:i:s');
        $userModel->last_login = date('Y-m-d H:i:s');
        $userModel->status = 1;//有效状态;

        if($userModel->validate()){
            if($userModel->save()){
                return json_encode(['retcode'=>0,'msg'=>'注册成功']);
            }else{
                return json_encode(['retcode'=>6,'msg'=>'其它异常']);
            }
        }else{
            return json_encode(['retcode'=>5,'msg'=>'提交信息有误']);

        }
    }
    public function actionDonate(){
        return $this->renderPartial('tabs/donate');
    }
    public function actionHome(){
        return $this->renderPartial('tabs/home');
    }
    public function actionRank(){
        return $this->renderPartial('tabs/rank');
    }
    public function actionProfile(){
        return $this->renderPartial('tabs/profile');
    }  
    public function actionTabs(){
        return $this->renderPartial('tabs');
    }  
    public function actionViewDonateItems(){
        return $this->renderPartial('viewDonateItems');
    }

    public function actionSendTelVerify(){

        if(isset($_GET['telephone'])&&!empty($_GET['telephone'])){
            $tel = $_GET['telephone'];
        }else{
            throw new \Exception("参数不合法!");
        }    
        $vCode =  SysUtils::generateTelVerifyNums();
        SysService::saveVerifyTmpCode($tel,$vCode);
        try {
            $phoneNumber1 = $tel;
            $appid = SysUtils::SMS_APP_ID;
            $appkey = SysUtils::SMS_APP_KEY;            
            $templId = SysUtils::SMS_TPL_ID;         
            $singleSender = new SmsSingleSender($appid, $appkey);
            $params = [$vCode];
            $result = $singleSender->sendWithParam("86", $phoneNumber1, $templId, $params, "", "", "");
            $rsp = json_decode($result);
            return $rsp;
        } catch (\Exception $e) {
            echo var_dump($e);
        }
       

    }
    
}
