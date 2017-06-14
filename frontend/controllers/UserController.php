<?php
namespace frontend\controllers;

use Yii;
use yii\web\Session;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use common\models\SysUtils;
use common\models\JsonUtils;
use common\models\UrlUtils;
use common\models\WechatCallbackapiTest;
use frontend\models\UserService;


/**
 * 用户管理
 */
class UserController extends Controller
{

	private $appid = 'wxcc2c9da0b0bb08e6';
	private $secret = '25cea6523782540f103c2768b67f6f86';

    	/**
     * 用于微信验证
     *
     * @return array
     */
	public function actionToken(){

		$wechatObj = new WechatCallbackapiTest();
		$wechatObj->valid();
	}

    public function actionGetUserInfo(){
		if(isset($_GET['code'])){
			$code = $_GET['code'];
		}else{
			die("授权失败!");
		}
		$access_token_info = UserService::getAccessToken($this->appid,$this->secret,$code);
        $access_token = $access_token_info['access_token'];
        $openId = $access_token_info['openid'];
        $wxUserInfo = UserService::getUserInfo($access_token,$openId);
        //判断所取的微信登录者信息中unionid是否存在
        if(!array_key_exists('unionid', $wxUserInfo)){
        	print_r('未能正确获取用户标识关键字!');
        	Yii::$app->end();
        }
     //   $this->redirect(UrlUtils::createUrl(["apply/go-apply",'markid'=>'fsadfasf423423423424242']]));
        $this->redirect(UrlUtils::createUrl(["apply/go-apply",'markid'=>$wxUserInfo['unionid']]));

    }
    	/**
     * 获取用户code，并跳转userinfo获取页面
     *
     * @return array
     */
	public function actionGetAuth(){
		$unionid = SysUtils::getValueBySessionKey('unionid');
        if(isset($unionid))	{	
		      return $this->redirect(UrlUtils::createUrl(["apply/go-apply",'markid'=>$unionid]));
        }
		$redirect_uri = urlencode(UrlUtils::createUrl("user/get-user-info"));
		$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$this->appid."&redirect_uri=$redirect_uri&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect";
		$this->redirect($url);
	}


    public function actionGetProfile(){

        $a = [
            'username'=>'熊少弟',
            'promocode' => 'fsdfdsfsd',
            'gameid' => 'U34234234329',
            'goodqty' => 88,
            'introducer' => 'U3552039207',
            'tel' => '15979008303',
            'avatar' => 'images/ICON.PNG'
        ];

        return json_encode($a);
    }


    public function actionSmsAuthCallback(){
        
    }



  
}
