<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\DataModel;

/**
 * 交易服务 
 */
class TradeService extends Model
{
   	 /**
     * 按页显示赠送明细
     *
     * @return array，if is null,return null;
     */
	public static function getDonateItemsByPage($userid,$page,$offset){
		$start = ($page-1)*$offset;
		$eSql = "select 
		         tradeid,
		         goodid,
		         goodname,
		         userid,
		         to_game_id,
		         username,
		         nickname,
		         qty,
		         create_at 
				 from biz_distribute_v 
				 where userid = $userid and goodid=1";
	    $limitSql = " limit $start,$offset";
	    $orderSql = " order by create_at desc";
	    $eSql .= $orderSql;
	    $eSql .= $limitSql;
	    
		return DataModel::execSql($eSql);;
	}
	public static function getDonateItemsCount($userid){
		$cSql = "select count(*) as cnt
				 from biz_trade
				 where userid = $userid and from_game_id is null ";
	    $result = DataModel::execSql($cSql);
	    return current($result)['cnt'];

	}
	public static function getAcceptItemsByPage($userid,$page,$offset){
		$start = ($page-1)*$offset;
		$eSql = "select 
		         tradeid,
		         goodid,
		         goodname,
		         userid,
		         from_game_id,
		         username,
		         nickname,
		         qty,
		         create_at 
				 from biz_accept_v 
				 where userid = $userid and goodid=1";
	    $limitSql = " limit $start,$offset";
	    $orderSql = " order by create_at desc";
	    $eSql .= $orderSql;
	    $eSql .= $limitSql;
	    
		return DataModel::execSql($eSql);;
	}
	public static function getAcceptItemsCount($userid){
		$cSql = "select count(*) as cnt
				 from biz_trade
				 where userid = $userid and to_game_id is null ";
	    $result = DataModel::execSql($cSql);
	    return current($result)['cnt'];

	}


}
