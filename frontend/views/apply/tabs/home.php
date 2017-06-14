<ion-view view-title="主页">
<ion-content ng-controller="HomeTabCtrl" ng-init="reloadUserInfo()">
  <!-- The content of the page -->
        <ion-refresher pulling-text="下拉更新" on-refresh="refreshUserInfo()"></ion-refresher>
        <div class="avatar">
		<div><img ng-src="{{currentUser.avatar}}"/></div>
		<div><span>{{currentUser.username}}</span></div>
		<div class="role">代理商</div>
		<div class="agentinfo">
			<div class="extendinfo text-pull-left">
				<div><span style="font-size: 16pt">推广码</span></div>
				<div><span>{{currentUser.promocode}}</span></div>
			</div>
			<div class="cardinfo text-pull-right">
				<div><span style="font-size: 16pt">房卡数</span></div>
				<div><span>{{currentUser.goodqty}}</span></div>
			</div>

		</div>

		</div>
		<div class="block-info">
			<div class="text-pull-left" style="padding-left: 20px;height:100%">ID/昵称</div> 
			<div class="text-pull-right" style="padding-right: 20px;height:100%">
						<ul>
							<li>{{currentUser.username}}</li>
							<li>{{currentUser.gameid}}</li>

						</ul>
		    </div>		
		</div>
		<div class="block-info">
				<div class="text-pull-left" style="padding-left: 20px;height:100%">推荐人</div> 
			<div class="text-pull-right" style="padding-right: 20px;height:100%">
						<strong>{{currentUser.introducer}}</strong>
			</div>
						
		</div>
		<div class="block-info">
					<div class="text-pull-left" style="padding-left: 20px;height:100%">手机号</div> 
			<div class="text-pull-right" style="padding-right: 20px;height:100%">
						<strong>{{currentUser.tel}}</strong>
			</div>
		</div>
</ion-content>
</ion-view>