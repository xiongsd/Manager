<?php
use common\models\UrlUtils;

?>
<script type="text/javascript">
    gameApp.controller('registerCtrl', function($scope,$http) {
        $scope.scope = $scope;
        $scope.gameid = "";
        $scope.nickname = "";
        $scope.telephone = "";
        $scope.verfiyCode = "";
        $scope.init = function(){

            var isRegistered = <?php echo $isRegistered;?>;
            if(isRegistered == 0){
              $scope.gameid = "请下载游戏注册使用";
            }

        };
        $scope.send = function(){

          if(!(/^1[34578]\d{9}$/.test($scope.telephone))){ 
              alert("手机号码有误，请重填");  
              return false; 
          } 
           $http({
              method: 'GET',
              url:"<?=UrlUtils::createUrl(['apply/send-tel-verify']);?>",
              params: {'telephone':$scope.telephone}
           }).success(function(data) {
               
           });

        }

      
    });
</script>
<div ng-controller="registerCtrl" ng-init="init()">
  <ion-header-bar align-title="center" class="bar-dark">
    <div class="buttons">
      <button class="button" ng-click="history.go(-1)">返回</button>
    </div>
    <h1 class="title"><?=$title?></h1>
    <button class="button button-icon icon ion-navicon" ng-click="share()"></button>
  </ion-header-bar>
  <ion-content class="has-header">
    <div class="apply_step2"></div>
    <div class="input-title">游戏信息</div>
    <div class="list list-reset" >
      <label class="item item-input item-reset">
        <span class="input-label input-label-reset">游戏ID</span>
        <input type="text" name="gameid" ng-model="scope.gameid"/>
      </label>
    </div>
    <div class="input-title">个人信息</div>
    <div class="list list-reset" >
      <label class="item item-input item-reset item-bot10">
        <span class="input-label input-label-reset">姓 名</span>
        <input type="text" name="nickname" ng-model="scope.nickname" />
      </label>
      <div class="item item-input item-reset item-bot10">
        <span class="input-label input-label-reset">手机号</span>
        <input style="width:40%" type="text" ng-model="scope.telephone" />
        <div class="input-tel-btn" style="width:45%" ng-click="send()"></div>
      </div>
      <label class="item item-input item-reset item-bot10">
        <span class="input-label input-label-reset">验证码</span>
        <input type="text" name="verfiyCode" ng-click="send()" ng-model="scope.verfiyCode" />
      </label>
    </div>
  </ion-content>
  <ion-footer-bar  class="bar-stable">
    <div class="btn-submit" ng-click="submit()"></div>
  </ion-footer-bar> 
</div>