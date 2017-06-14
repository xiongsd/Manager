<?php

use yii\helpers\Url;
use common\models\UrlUtils;

?>
<script type="text/javascript">
  gameApp.config(function($stateProvider, $urlRouterProvider,$ionicConfigProvider,$httpProvider) {
      $httpProvider.defaults.cache = false;
      $ionicConfigProvider.tabs.position('bottom');
      $ionicConfigProvider.navBar.alignTitle('center');
      $stateProvider
        .state('tabs', {
          url: "/tab",
          abstract: true,
          templateUrl: "templates/tabs.html"
        })
        .state('tabs.home', {
          url: "/home",
          cache:false,
          views: {
            'home-tab': {
              templateUrl: "<?=Url::toRoute('apply/home')?>",
              controller: 'HomeTabCtrl'
            }
          }
        })
        .state('tabs.rank', {
          url: "/rank",
          cache:false,
          views: {
            'rank-tab': {
              templateUrl: "<?=Url::toRoute('apply/rank')?>",
              controller: 'RankTabCtrl'
            }
          }
        })
        .state('tabs.donate', {
          url: "/donate",
          cache:false,
          views: {
            'donate-tab': {
              templateUrl: "<?=Url::toRoute('apply/donate')?>",
              controller: 'DonateTabCtrl'
            }
          }
        })
                .state('tabs.profile', {
          url: "/profile",
          cache:false,
          views: {
            'profile-tab': {
              templateUrl: "<?=Url::toRoute('apply/profile')?>",
              controller: 'ProfileTabCtrl'
            }
          }
        });


        $urlRouterProvider.otherwise("/tab/home");

    })
    .controller('HomeTabCtrl', function($scope,$http) {
        $scope.currentUser = {};
        $scope.loadUserInfo = function(){
            $http({
              method: 'GET',
              url:"<?=UrlUtils::createUrl(['user/get-profile']);?>",
            }).success(function(data) {

                   $scope.currentUser = data;              
             
            });

        };
        $scope.reloadUserInfo = function(){
           $scope.loadUserInfo();

        }
        $scope.refreshUserInfo = function(){
           $scope.loadUserInfo();
           $scope.$broadcast("scroll.refreshComplete");

        }
    })
    .controller('RankTabCtrl', function($scope) {

    })
    .controller('DonateTabCtrl', function($scope,$http,$ionicModal) {
        $scope.currentUser = [];
        $scope.toCurPage = 1;
        $scope.isLastPage = false;
        $scope.toDonateItems = [];
        $scope.fromCurPage = 1;
        $scope.isLastPage2 = false;
        $scope.fromDonateItems = [];

        $scope.loadUserInfo = function(){
          $http({
              method: 'GET',
              url:"<?=UrlUtils::createUrl(['user/get-profile']);?>",
          }).success(function(data) {
              $scope.currentUser = data;     
          });
        };
        $scope.init = function(){
          $scope.loadUserInfo();
          $scope.loadToDonateItems();

        };
        $ionicModal.fromTemplateUrl("<?=Url::toRoute('apply/view-donate-items')?>", function(modal) {
          $scope.viewDonateItemsModel = modal;
        }, {
          scope: $scope
        });
        $scope.viewDonateItems = function(){
          $scope.viewDonateItemsModel.show();
        };
        $scope.closeDonateItems = function(){
          $scope.viewDonateItemsModel.hide();

        };
        $scope.loadToDonateItems = function(){
          $http({
              method: 'GET',
              params: {'page':$scope.toCurPage},
              url:"<?=UrlUtils::createUrl(['trade/to-donate-items']);?>",
          }).success(function(r) {
              var datas = r.data;
              for(var i=0;i<datas.length;i++){
                $scope.toDonateItems.push(datas[i]);  
              }
              $scope.isLastPage = r.isLastPage; 
          });

        }
        $scope.loadToDonateMore = function(){
          $scope.toCurPage++;
          $scope.loadToDonateItems;
        }

    })
    .controller('ProfileTabCtrl', function($scope) {

    });
    </script>             
    <ion-nav-bar class="bar-dark">
      <ion-nav-back-button>
      </ion-nav-back-button>
    </ion-nav-bar>             
    <ion-nav-view></ion-nav-view>
    <script id="templates/tabs.html" type="text/ng-template">
      <ion-tabs class="tabs-icon-top tabs-stable ">
        <ion-tab title="主页" icon="ion-home" href="#/tab/home">
          <ion-nav-view name="home-tab"></ion-nav-view>
        </ion-tab>
        <ion-tab title="业绩排名" icon="ion-home" href="#/tab/rank">
          <ion-nav-view name="rank-tab"></ion-nav-view>
        </ion-tab>
        <ion-tab title="房卡受赠" icon="ion-star" href="#/tab/donate">
          <ion-nav-view name="donate-tab"></ion-nav-view>
        </ion-tab>
        <ion-tab title="我的" icon="ion-home" href="#/tab/profile">
          <ion-nav-view name="profile-tab"></ion-nav-view>
        </ion-tab>
      </ion-tabs>
    </script>


