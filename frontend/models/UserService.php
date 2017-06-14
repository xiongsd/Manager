<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\web\Session;
use common\models\HttpUtils;
use common\models\DataModel;

/**
 * 代理商(用户)服务
 */
class UserService extends Model
{
    /**
     * 获取用户信息
     *
     * @return array
     */
	public static function getUserInfo($token,$openid){
		$url = "https://api.weixin.qq.com/sns/userinfo?access_token=$token&openid=$openid&lang=zh_CN";
		$userinfo  = HttpUtils::getJson($url);	
        $session = Yii::$app->session;
        $session->set('unionid', $userinfo['unionid']);
		return $userinfo;
	}
    	/**
     * 获取微信TOKEN
     *
     * @return array
     */
	public static function getAccessToken($appid,$secret,$code){
        $cache = Yii::$app->cache; 
        $cache_token_info = $cache->get('access_token_info'); 
        $token_expire = $cache->get('expire_time'); 
        if((time()>$token_expire)||($cache_token_info === false)){
            $new_token_info = self::getNewAccessToken($appid,$secret,$code);
            $cache->set('access_token_info', $new_token_info); 
            $cache->set('expire_time', time()+7000); 
            return $new_token_info;
        }else{
            return $cache_token_info;            
        }

	}
    	/**
     * 向服务器获取微信TOKEN
     *
     * @return array
     */
    public static function getNewAccessToken($appid,$secret,$code){
        $tokenUrl = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$secret."&code=".$code."&grant_type=authorization_code"; 
        return HttpUtils::getJson($tokenUrl); 

    }
    	/**
     * 根据登录用户的身份标识，从游戏服务器中查找是否存在;
     *
     * @return array
     */
    public static function searchUserFromBackend($markid){
        $eSql = "select * 
                 from sec_users 
                 where status = 1 and markid = '$markid'";
        $result = DataModel::execSql($eSql);
        if(empty($result)){
            return null;
        }else{
            return current($result);
        }
       

    }


    public static function getUserInfoOnGamePlatform(){
        $eSql = "select * 
                 from sec_users 
                 where status = 1 and markid = $markid";
        $result = DataModel::execSql($eSql);
        return $result[0];
        
    }


}
