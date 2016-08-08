<!DOCTYPE html>
<html lang="en" ng-app="mushaf">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Mushaf</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/app.css') }}">
    <!-- Bootstrap -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap-rtl.min.css') }}" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
        #mushaf .container {
            margin-top: 5px;
            width: 910px !important;
            background-image: url('/assets/img/qbook.png');
            background-repeat: no-repeat;
            background-size: cover;
            text-align: center;
            padding: 10px 20px 0px 20px;
        }   
        #mushaf > .container > .row > .col-lg-6 > .right, #mushaf > .container > .row > .col-lg-6 > .left{
            /*background-color: #F9FBEE;*/
            background-image: url('/assets/img/npage.png');
            background-repeat: no-repeat;
            background-size: cover;
            text-align: center;
            padding: 35px 0 35px 0;
            height: 623px;

        }
    </style>
    <!--AngularJS-->

    <script src="{{ asset('assets/js/angular/angular.min.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular-route.js"></script>
    <script src="{{ asset('assets/js/angular/angular-cookies.min.js') }}"></script>
    <script src="{{ asset('assets/js/angular-bind-html-compile/angular-bind-html-compile.min.js') }}"></script>	
    <script src="{{ asset('assets/js/angular.audio.js') }}"></script> 
	
	<script src="{{ asset('assets/js/ui-bootstrap-tpls-2.0.0.min.js') }}"></script>
  <script src="{{ asset('assets/js/app/app.js') }}"></script>
  
  </head>
  <body ng-controller="mushafController" data-ng-init="init()">
  	<loading></loading>
  <div id="menue" class="menueStyle">
	  <a href="javascript:void(0)" class="closebtn" onclick="closeMenue()">×</a>
      <label>الانتقال إلى:</label>
	  <div class="row">
	  	<label>رقم الصفحة</label>
	  	<div class="input-group">
		   <input type="number" min="1" max="604"  class="form-control" ng-model="pageNo" placeholder="رقم الصفحة" dl-enter-key="goPage(pageNo);">
		   <span class="input-group-btn">
		        <button class="btn btn-success" type="button" ng-click="goPage(pageNo)">
		        	<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
		        </button>
		   </span>
		</div>
	  </div>
      <div class="row">
        <label>رقم الجزء</label>
        <div class="input-group">
           <input type="number" min="1" max="30"  class="form-control" ng-model="juz2No" placeholder="رقم الجزء" dl-enter-key="goPage(juz[juz2No-1].p_ID);">
           <span class="input-group-btn">
                <button class="btn btn-success" type="button" ng-click="goPage(juz[juz2No-1].p_ID)">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                </button>
           </span>
        </div>
      </div>
	  <div class="row">
	  	<label>السورة</label>
	  	<div class="input-group">
		   <select class="form-control" data-ng-options="o.name for o in fehras track by o.p_ID" data-ng-model="selectedOption"  ng-change="goPage(selectedOption.p_ID)"></select>
		   <span class="input-group-btn">
		        <button class="btn btn-success" type="button" ng-click="goPage(selectedOption.p_ID)">
		        	<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
		        </button>
		   </span>
		</div>
	  </div>
	  <div class="row">
        <label>رقم الآية</label>
        <div class="input-group">
           <input type="number" min="1" max="<%fehras[selectedOption.ID-1].total_aya%>"  class="form-control" data-ng-model="aya2No" placeholder="رقم الآية" dl-enter-key="goAya(aya2No);">
           <span class="input-group-btn">
                <button class="btn btn-success" type="button" ng-click="goAya(aya2No)">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                </button>
           </span>
        </div>
      </div>
	</div>
    <div id="search" class="menueStyle">
      <a href="javascript:void(0)" class="closebtn" onclick="closeMenue()">×</a>
      <div class="row">
        <label>بحث عن</label>
        <div class="input-group">
           <input type="text" class="form-control" ng-change="search()"  ng-model="searchWords" placeholder="كلمات البحث">
           <span class="input-group-btn">
                <button class="btn btn-success" type="button" ng-click="search()">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                </button>
           </span>
        </div>
      </div>
      <div class="row searchResult">
        <ul>
        <li ng-repeat="x in searchResult" ng-click="goWord(x.ID,x.ayaNo,x.sura)"><span class="ayaResult"><% x.aya %></span> [سورة <% fehras[x.sura-1].name %>، <% x.ayaNo %>]</li>
        </ul>
      </div>
    </div>
    
    <section id="mushaf">
        <div class="next" ng-click="nextPage()"></div>
        <div class="back" ng-click="backPage()"></div>
        <button id="MenueButton" class="btn btn-sample " onclick="openMenue()">☚</button>
        <button id="SearchButton" class="btn btn-sample " onclick="openSearch()">🔍</button>
        
    	<div class="container">
            
        	<div class="row">
        	 <div class="col-lg-6  col-lg-offset-0 col-xs-offset-3 col-xs-6 ">
                <div class='row header'>
                    <div class='col-xs-6' data-ng-bind="'ﰸ'+rPage.juz">
                       
                    </div>
                    <div class='col-xs-6' data-ng-bind="'ﮌ'+rPage.sura">                
                       
                    </div>
                </div>
                <div class="right" bind-html-compile="rPage.content">                    
                
            
                </div>
                <div class='row footer'>
                    <div class='col-xs-12  rightPageNo'  ng-bind-html="rPage.page">
                        1
                    </div>
                </div>
        	 </div>
             
        	 <div class="col-lg-6  col-lg-offset-0 col-lg-offset-0 col-xs-offset-3 col-xs-6 ">
                <div class='row header'>
                    <div class='col-xs-6' data-ng-bind="'ﰸ'+lPage.juz">
                       
                    </div>
                    <div class='col-xs-6' data-ng-bind="'ﮌ'+lPage.sura">                
                       
                    </div>
                </div>
                <div class="left" bind-html-compile="lPage.content">                    
                
            
                </div>
                <div class='row footer'>
                    <div class='col-xs-12  leftPageNo' ng-bind-html="lPage.page">
                        2
                    </div>
                </div>
        	 </div>
        	</div>
            
    	</div>
        
    </section>
    
    <script>

    	function openMenue() {
		    $("#menue").width("300px");
		}
        function openSearch() {
            $("#search").width("300px");
        }
        function openListen() {
            $("#listen").width("300px");
        }
		function closeMenue() {
		    $(".menueStyle").width("0");
		}
        
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
    
    </script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/quran-data.js') }}"></script>
    
  </body>
</html>