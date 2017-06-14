<?php
namespace common\models;

use Yii;

class SysUtils{

	//操作结果
	const SUCCESS = 1;
	const FAILURE = 0;
    //微信
	const WEIXIN_APP_ID = "wx163bb8552cee976d";
	const WEIXIN_SECRET = "21d263bb6b2bb544c6d844c29527e665";
	//腾讯云短信
	const SMS_APP_ID = 1400032845;
	const SMS_APP_KEY = "b82a940c0c539a45ee4064957183b23a";
	const SMS_TPL_ID = 22991;
	/**
     * 根据缓存字段，获取缓存数据
     *
     * @return value,return false if cache is not in cache;
     */
	public static function getValueByCacheKey($cacheKey){
		$cache = Yii::$app->cache; 
		$value = $cache->get($cacheKey);
		if($value){
			return $value;
		}else{
			return false; 
		}
	}

	public static function getValueBySessionKey($skey){
		$session = Yii::$app->session;
		return $session->get($skey);
	}

	public static function generateTelVerifyNums(){
		$char = "0,1,2,3,4,5,6,7,8,9";
		$list=explode(",",$char);
		$authnum = "";
		for($i=0;$i<6;$i++){
			$randnum=rand(0,9); 
			$authnum.=$list[$randnum];
		}
		return $authnum;
	}

	
}
