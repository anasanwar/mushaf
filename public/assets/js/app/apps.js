var app = angular.module('mushaf', ['ngCookies','angular-bind-html-compile'
], function($interpolateProvider) {
	$interpolateProvider.startSymbol('<%');
	$interpolateProvider.endSymbol('%>');
	  

}).constant('API_URL', 'http://localhost/mushaf/public/');

app.controller('mushafController', function($scope,$sce, $http, API_URL, searchService, $cookieStore){
	$scope.rightPage = [];
	$scope.leftPage = [];
	$scope.aPage = [];
	$scope.fehras = [];
	$scope.juz = [];
	$scope.searchResult = [];
	$scope.init = function() {
		$scope.activeMenu = 1;
		$scope.page = $cookieStore.get('page') || 1;
		$scope.juz2No = 1;
		$scope.aya2No = 1;
		$scope.maxAya = 7;
		$scope.loading = true;
		
		
		$scope.allFehras();		
		$scope.allJuz();		
		$scope.goPage($scope.page);
				
	}

	$scope.goWord = function(ID,aya,sura){
		$scope.selectedOption = $scope.fehras[sura-1];
		$scope.goAya(aya);
		
	}
	$scope.goAya = function(aya){
		$scope.loading = true;
		$sura = $scope.selectedOption.ID;
		$http({
			  method: 'GET',
			  url: API_URL+'goAya',
			  params: {
	            surah: $scope.selectedOption.ID,
	            aya: aya
	          }
			}).then(function successCallback(response) {

			   		$scope.rightPage 	= response.data.rightWords;
					$scope.leftPage 	= response.data.leftWords;

					$scope.page = response.data.page;
					$scope.aPage['odd'] = getArabicNumbers($scope.page);
					$scope.aPage['even'] = getArabicNumbers($scope.page+1);
					$scope.pageNo = $scope.page;
					console.log($sura);
					$scope.activeMenu =  $sura+"_"+aya;

					$scope.rSurah 		= $scope.fehras[response.data.rSurah-1];
					$scope.lSurah 		= $scope.fehras[response.data.lSurah-1];
					$scope.selectedOption = $scope.rSurah;
					$scope.rJuz 		= $scope.juz[response.data.rJuz-1];
					$scope.lJuz 		= $scope.juz[response.data.lJuz-1];
					$scope.juz2No		= $scope.rJuz.ID;
					$cookieStore.put("page", $scope.page);
					closeMenue();
					
					$scope.loading 		= false;

			  }, function errorCallback(response) {
			    $scope.page = 1000;
			    $scope.words = "anwar";
		});
		
	}

	$scope.nextPage = function(){	
		if($scope.page < 603){		
			$scope.goPage($scope.page + 2);
		}
	}

	$scope.backPage = function(){
		 if($scope.page > 1){
			$scope.goPage($scope.page - 2);
		}
	}

	$scope.goPage = function(pageNo){
		$scope.loading = true;
		if(isEven(pageNo)){
			pageNo -=1;
		}
		$http({
			  method: 'GET',
			  url: API_URL+'turne',
			  params: {
	            page: pageNo
	          }
			}).then(function successCallback(response) {

			   		$scope.rightPage 	  = response.data.rightWords;
					$scope.leftPage 	  = response.data.leftWords;
					
					$scope.page = pageNo;
					$scope.aPage['odd'] = getArabicNumbers($scope.page);
					$scope.aPage['even'] = getArabicNumbers($scope.page+1);
					$scope.pageNo = $scope.page;
					$scope.aya2No = 1;
					$scope.rSurah 		= $scope.fehras[response.data.rSurah-1];
					$scope.selectedOption = $scope.rSurah;
					$scope.lSurah 		= $scope.fehras[response.data.lSurah-1];
					$scope.rJuz 		= $scope.juz[response.data.rJuz-1];
					$scope.lJuz 		= $scope.juz[response.data.lJuz-1];
					$scope.juz2No		= $scope.rJuz.ID;
					$cookieStore.put("page", $scope.page);
					closeMenue();
					
					$scope.loading 		= false;

			  }, function errorCallback(response) {
			    $scope.page = 1000;
			    $scope.words = "anwar";
		});

	}
	
	$scope.allFehras = function(){
		$http({
			  method: 'GET',
			  url: API_URL+'allFehras'
			}).then(function successCallback(response) {
				
			   	$scope.fehras 		  = response.data;
			   	$scope.selectedOption = response.data[0];
			   	$scope.rSurah 		= $scope.fehras[0];
				$scope.lSurah 		= $scope.fehras[1];
			  }, function errorCallback(response) {
			    $scope.page = 1000;
			    $scope.words = "anwar";
		});
	}

	$scope.allJuz = function(){
		$http({
			  method: 'GET',
			  url: API_URL+'allJuz'
			}).then(function successCallback(response) {
				
			   	$scope.juz 		  = response.data;
			   	

			  }, function errorCallback(response) {
			    $scope.page = 1000;
			    $scope.words = "anwar";
		});
	}

	$scope.search = function(){
		$scope.searchResult = [];
		if($scope.searchWords.length > 2){
			searchService.search($scope.searchWords).then(function successCallback(response) {			   	
			   	$scope.searchResult = response.data;
			  }, function errorCallback(response) {
			    $scope.searchResult = [{"aya":"لا يوجد نتائج"}];
        	});
		}
	}
});



app.directive('loading', function () {
      return {
        restrict: 'E',
        replace:true,
        template: '<div class="loading"><img src="http://www.nasa.gov/multimedia/videogallery/ajax-loader.gif" width="20" height="20" />جاري التحميل</div>',
        link: function (scope, element, attr) {
              scope.$watch('loading', function (val) {
                  if (val)
                      $(element).show();
                  else
                      $(element).hide();
              });
        }
      }
  });
var map =
[
	"&\#1632;","&\#1633;","&\#1634;","&\#1635;","&\#1636;",
	"&\#1637;","&\#1638;","&\#1639;","&\#1640;","&\#1641;"
];

function getArabicNumbers(str)
{
    var newStr = "";

    str = String(str);

    for(i=0; i<str.length; i++)
    {
        newStr += map[parseInt(str.charAt(i))];
    }

    return newStr;
}

function isEven(n) {
   return n % 2 == 0;
}
app.config(function($sceProvider) {
  // Completely disable SCE.  For demonstration purposes only!
  // Do not use in new projects.
  $sceProvider.enabled(false);
});

app.service('searchService', ['$http','API_URL', function($http,API_URL){
    return {
        search: function(keywords){
        	//console.log(keywords);
        	return $http({method: 'GET', url: API_URL+'search', params: {words: keywords}});
        }
    }
}]);
