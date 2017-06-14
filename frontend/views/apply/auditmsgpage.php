<?php
use common\models\UrlUtils;

?>
<script type="text/javascript">
    angular.module('GameApp', ['ionic'])
		.controller('Ctrl', function($scope,$http) {

    });

</script>
<ion-header-bar align-title="center" class="bar-dark">
  <div class="buttons">
    <button class="button" ng-click="goBack()">返回</button>
  </div>
  <h1 class="title"><?=$title?></h1>
  <button class="button button-icon icon ion-navicon" ng-click="share()"></button>
  </div>
</ion-header-bar>
<ion-content>
	<div class="auditmsg"></div>
	<div class="msg">
		<h3><?=$auditmsg?></h3>
		<h5>
    <?php
        if($auditmsg=='审核失败'){
          echo '未通过，详情请咨询客服';
        }else{
          echo '审核通过我们将以短信方式通知您';
        }
    ?>
    </h5>
	</div>


</ion-content>
<ion-footer-bar  class="bar-stable">
	<div class="btn-submit" ng-click="next()"></div>
</ion-footer-bar> 