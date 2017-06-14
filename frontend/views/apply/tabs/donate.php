<?php
use common\models\UrlUtils;

?>
<ion-view view-title="房卡受赠">
	<ion-content ng-controller="DonateTabCtrl" ng-init="init()">
		<div class="row info_box_list">
		      <div class="col col-25 info_box">
		        <strong>代理姓名</strong>
		        <span>{{currentUser.username}}</span>
		      </div>
		      <div class="col col-25 info_box">
		        <strong>游戏ID</strong>
		        <span>{{currentUser.gameid}}</span>
		      </div>
		      <div class="col col-25 info_box">
		        <strong>现有房卡</strong>
		        <span>{{currentUser.goodqty}}</span>
		      </div>
		      <div class="col col-25 info_box">
		      </div>
		</div>
		<div style="height:200px;background:#eeeeee">
            <div style="float:right;padding-right:30px;padding-top: 100px">
            	<span><a ng-click="viewDonateItems()" style="color:#a05252">查看明细</a></span>
            </div>
		</div>
		<div class="list list-reset" >
		<label class="item item-input item-reset">
		  <span class="input-label input-label-reset">游戏ID</span>
		  <input type="text" name="gameid">
		</label>
		</div>
		<div class="list list-reset" >
			<label class="item item-input item-reset">
			  <span class="input-label input-label-reset">赠送数</span>
			  <input type="text" name="qty">
			</label>
		</div>
		<div ng-if="donateSucc=true"><span>赠送成功</span></div>
		<button class="button button-full button-game">赠送</button>
	</ion-content>
</ion-view>