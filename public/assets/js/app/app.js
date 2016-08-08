var app = angular.module('mushaf', ['ui.bootstrap','ngCookies', 'angular-bind-html-compile', 'ngAudio'], function($interpolateProvider) {
	$interpolateProvider.startSymbol('<%');
	$interpolateProvider.endSymbol('%>');
	  

}).constant('API_URL', '/');

app.controller('mushafController', function($scope,$sce, $http, API_URL, searchService, $cookieStore,ngAudio){
	$scope.rPage = [];
	$scope.lPage = [];
	$scope.juz = [];
	$scope.fehras = [];
	$scope.searchResult = [];
	$scope.page = 1;	
	$scope.searchResult = [];

	$scope.init = function() {
		$scope.rPage['page'] = 1;
		//$scope.loading 		= true;
		$scope.juz2No = 1;
		$scope.goOddPage($scope.page);
		$scope.goEvenPage(++$scope.page);
		$scope.loading 		= false;
		$scope.allJuz();
		$scope.allFehras();
	}
	
	$scope.nextPage = function(){	
		if($scope.page < 603){	
			$scope.goPage(++$scope.page);	
			
		}
	}

	$scope.backPage = function(){
		 if($scope.page > 2){
		 	$scope.page -=3;
			$scope.goPage($scope.page);
			
		}
	}

	$scope.goAya = function(aya){
		$sura = $scope.selectedOption.ID;
		$http({
			  method: 'GET',
			  url: API_URL+'goAyaPage',
			  params: {
	            surah: $sura,
	            aya: aya
	          }
			}).then(function successCallback(response) {
				
			   	$scope.goPage(response.data);
			   	$scope.activeMenu =  pad($sura,3)+pad(aya,3);

			  }, function errorCallback(response) {
			    
			    $scope.words = "anwar";
		});
	}

	$scope.goPage = function(pageNo){

		//$scope.loading 		= true;	
		$scope.rPage = [];
		$scope.lPage = [];
		$scope.rPage['page'] = '&nbsp;';
		$scope.lPage['page'] = '&nbsp;';
		 if(pageNo >= 1 || pageNo <= 604){
		 	if(isEven(pageNo)){
		 		$scope.page = pageNo - 1;
		 	}else {
		 		$scope.page = pageNo;
		 	}
		 	
			$scope.goOddPage($scope.page);
			$scope.goEvenPage(++$scope.page);
			$scope.loading 		= false;
		}
	}
	$scope.goOddPage = function(pageNo){
		
		
		$http({
			  method: 'GET',
			  url: API_URL+'saved/'+pageNo+'.json'
			}).then(function successCallback(response) {

			   		$scope.rPage 	  = response.data;
					
					
					closeMenue();
					
					
			  }, function errorCallback(response) {
			    //$scope.page = 1000;
			    $scope.words = "anwar";
		});

	}
	$scope.goEvenPage = function(pageNo){
		
		$http({
			  method: 'GET',
			  url: API_URL+'saved/'+pageNo+'.json'
			}).then(function successCallback(response) {

			   		$scope.lPage 	  = response.data;
					
					
					closeMenue();
					
					
			  }, function errorCallback(response) {
			    //$scope.page = 1000;
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
	$scope.search = function(){
		
		if($scope.searchWords.length > 2){
			searchService.search($scope.searchWords).then(function successCallback(response) {			   	
			   	$scope.searchResult = response.data;
			  }, function errorCallback(response) {
			    $scope.searchResult = [{"aya":"لا يوجد نتائج"}];
        	});
		}
	}
	$scope.goWord = function(ID,aya,sura){
		$scope.selectedOption = $scope.fehras[sura-1];
		$scope.goAya(aya);
		
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
function pad(n, length) {
  var len = length - (''+n).length;
  return (len > 0 ? new Array(++len).join('0') : '') + n
}
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


app.directive('dlEnterKey', function() {
    return function(scope, element, attrs) {

        element.bind("keydown keypress", function(event) {
            var keyCode = event.which || event.keyCode;

            // If enter key is pressed
            if (keyCode === 13) {
                scope.$apply(function() {
                        // Evaluate the expression
                    scope.$eval(attrs.dlEnterKey);
                });

                event.preventDefault();
            }
        });
    };
});