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
    <div id="listen" class="menueStyle">
      <a href="javascript:void(0)" class="closebtn" onclick="closeMenue()">×</a>
      <div class="row">
        <label>اختر القارئ</label>

        <div class="input-group">
           <select class="form-control" data-ng-model="selectedListen">
            <option value=""></option>
            <option value="AbdulSamad_64kbps_QuranExplorer.Com" selected="selected">AbdulSamad_64kbps_QuranExplorer.Com</option>
            <option value="Abdul_Basit_Mujawwad_128kbps">عبد الباسط مجود</option>
            <option value="Abdul_Basit_Murattal_192kbps">عبد الباسط مرتل</option>
            <option value="Abdul_Basit_Murattal_64kbps">Abdul_Basit_Murattal_64kbps</option>
            <option value="Abdullaah_3awwaad_Al-Juhaynee_128kbps">Abdullaah_3awwaad_Al-Juhaynee_128kbps</option>
            <option value="Abdullah_Basfar_192kbps">Abdullah_Basfar_192kbps</option>
            <option value="Abdullah_Basfar_32kbps">Abdullah_Basfar_32kbps</option>
            <option value="Abdullah_Basfar_64kbps">Abdullah_Basfar_64kbps</option>
            <option value="Abdullah_Matroud_128kbps">Abdullah_Matroud_128kbps</option>
            <option value="Abdurrahmaan_As-Sudais_192kbps">Abdurrahmaan_As-Sudais_192kbps</option>
            <option value="Abdurrahmaan_As-Sudais_64kbps">Abdurrahmaan_As-Sudais_64kbps</option>
            <option value="Abu_Bakr_Ash-Shaatree_128kbps">Abu_Bakr_Ash-Shaatree_128kbps</option>
            <option value="Abu_Bakr_Ash-Shaatree_64kbps">Abu_Bakr_Ash-Shaatree_64kbps</option>
            <option value="Ahmed_Neana_128kbps">Ahmed_Neana_128kbps</option>
            <option value="Ahmed_ibn_Ali_al-Ajamy_128kbps_ketaballah.net">Ahmed_ibn_Ali_al-Ajamy_128kbps_ketaballah.net</option>
            <option value="Ahmed_ibn_Ali_al-Ajamy_64kbps_QuranExplorer.Com">Ahmed_ibn_Ali_al-Ajamy_64kbps_QuranExplorer.Com</option>
            <option value="Akram_AlAlaqimy_128kbps">Akram_AlAlaqimy_128kbps</option>
            <option value="Alafasy_128kbps">Alafasy_128kbps</option>
            <option value="Alafasy_64kbps">Alafasy_64kbps</option>
            <option value="Ali_Hajjaj_AlSuesy_128kbps">Ali_Hajjaj_AlSuesy_128kbps</option>
            <option value="Ali_Jaber_64kbps">Ali_Jaber_64kbps</option>
            <option value="English/Sahih_Intnl_Ibrahim_Walk_192kbps">English/Sahih_Intnl_Ibrahim_Walk_192kbps</option>
            <option value="Fares_Abbad_64kbps">Fares_Abbad_64kbps</option>
            <option value="Ghamadi_40kbps">Ghamadi_40kbps</option>
            <option value="Hani_Rifai_192kbps">Hani_Rifai_192kbps</option>
            <option value="Hani_Rifai_64kbps">Hani_Rifai_64kbps</option>
            <option value="Hudhaify_128kbps">Hudhaify_128kbps</option>
            <option value="Hudhaify_32kbps">Hudhaify_32kbps</option>
            <option value="Hudhaify_64kbps">Hudhaify_64kbps</option>
            <option value="Husary_128kbps">Husary_128kbps</option>
            <option value="Husary_128kbps_Mujawwad">Husary_128kbps_Mujawwad</option>
            <option value="Husary_64kbps">Husary_64kbps</option>
            <option value="Husary_Muallim_128kbps">Husary_Muallim_128kbps</option>
            <option value="Husary_Mujawwad_64kbps">Husary_Mujawwad_64kbps</option>
            <option value="Ibrahim_Akhdar_32kbps">Ibrahim_Akhdar_32kbps</option>
            <option value="Ibrahim_Akhdar_64kbps">Ibrahim_Akhdar_64kbps</option>
            <option value="Karim_Mansoori_40kbps">Karim_Mansoori_40kbps</option>
            <option value="Khaalid_Abdullaah_al-Qahtaanee_192kbps">Khaalid_Abdullaah_al-Qahtaanee_192kbps</option>
            <option value="MaherAlMuaiqly128kbps">MaherAlMuaiqly128kbps</option>
            <option value="Maher_AlMuaiqly_64kbps">Maher_AlMuaiqly_64kbps</option>
            <option value="Menshawi_16kbps">Menshawi_16kbps</option>
            <option value="Menshawi_32kbps">Menshawi_32kbps</option>
            <option value="Minshawy_Mujawwad_192kbps">Minshawy_Mujawwad_192kbps</option>
            <option value="Minshawy_Mujawwad_64kbps">Minshawy_Mujawwad_64kbps</option>
            <option value="Minshawy_Murattal_128kbps">Minshawy_Murattal_128kbps</option>
            <option value="Mohammad_al_Tablaway_128kbps">Mohammad_al_Tablaway_128kbps</option>
            <option value="Mohammad_al_Tablaway_64kbps">Mohammad_al_Tablaway_64kbps</option>
            <option value="Muhammad_AbdulKareem_128kbps">Muhammad_AbdulKareem_128kbps</option>
            <option value="Muhammad_Ayyoub_128kbps">Muhammad_Ayyoub_128kbps</option>
            <option value="Muhammad_Ayyoub_32kbps">Muhammad_Ayyoub_32kbps</option>
            <option value="Muhammad_Ayyoub_64kbps">Muhammad_Ayyoub_64kbps</option>
            <option value="Muhammad_Jibreel_128kbps">Muhammad_Jibreel_128kbps</option>
            <option value="Muhammad_Jibreel_64kbps">Muhammad_Jibreel_64kbps</option>
            <option value="Muhsin_Al_Qasim_192kbps">Muhsin_Al_Qasim_192kbps</option>
            <option value="MultiLanguage/Basfar_Walk_192kbps">MultiLanguage/Basfar_Walk_192kbps</option>
            <option value="Mustafa_Ismail_48kbps">Mustafa_Ismail_48kbps</option>
            <option value="Nasser_Alqatami_128kbps">Nasser_Alqatami_128kbps</option>
            <option value="Parhizgar_48kbps">Parhizgar_48kbps</option>
            <option value="Sahl_Yassin_128kbps">Sahl_Yassin_128kbps</option>
            <option value="Salaah_AbdulRahman_Bukhatir_128kbps">Salaah_AbdulRahman_Bukhatir_128kbps</option>
            <option value="Salah_Al_Budair_128kbps">Salah_Al_Budair_128kbps</option>
            <option value="Saood_ash-Shuraym_128kbps">Saood_ash-Shuraym_128kbps</option>
            <option value="Saood_ash-Shuraym_64kbps">Saood_ash-Shuraym_64kbps</option>
            <option value="Yaser_Salamah_128kbps">Yaser_Salamah_128kbps</option>
            <option value="Yasser_Ad-Dussary_128kbps">Yasser_Ad-Dussary_128kbps</option>
            <option value="ahmed_ibn_ali_al_ajamy_128kbps">ahmed_ibn_ali_al_ajamy_128kbps</option>
            <option value="aziz_alili_128kbps">aziz_alili_128kbps</option>
            <option value="khalefa_al_tunaiji_64kbps">khalefa_al_tunaiji_64kbps</option>
            <option value="mahmoud_ali_al_banna_32kbps">mahmoud_ali_al_banna_32kbps</option>
            <option value="translations/Fooladvand_Hedayatfar_40Kbps">translations/Fooladvand_Hedayatfar_40Kbps</option>
            <option value="translations/Makarem_Kabiri_16Kbps">translations/Makarem_Kabiri_16Kbps</option>
            <option value="translations/azerbaijani/balayev">translations/azerbaijani/balayev</option>
            <option value="translations/besim_korkut_ajet_po_ajet">translations/besim_korkut_ajet_po_ajet</option>
            <option value="translations/urdu_farhat_hashmi">translations/urdu_farhat_hashmi</option>
            <option value="translations/urdu_shamshad_ali_khan_46kbps">translations/urdu_shamshad_ali_khan_46kbps</option>
            <option value="warsh/warsh_Abdul_Basit_128kbps">warsh/warsh_Abdul_Basit_128kbps</option>
            <option value="warsh/warsh_ibrahim_aldosary_128kbps">warsh/warsh_ibrahim_aldosary_128kbps</option>
            <option value="warsh/warsh_yassin_al_jazaery_64kbps">warsh/warsh_yassin_al_jazaery_64kbps</option>
          </select>
           <span class="input-group-btn">
                <button class="btn btn-success" type="button" ng-click="playMe()">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                </button>
           </span>
        </div>
      </div>
    </div>
    <section id="mushaf">
        <div class="next" ng-click="nextPage()"></div>
        <div class="back" ng-click="backPage()"></div>
        <button id="MenueButton" class="btn btn-sample " onclick="openMenue()">☚</button>
        <button id="SearchButton" class="btn btn-sample " onclick="openSearch()">🔍</button>
        <button id="ListenButton" class="btn btn-sample " onclick="openListen()">🕪</button>
    	<div class="container">
            
        	<div class="row">
        	 <div class="col-lg-6  col-lg-offset-0 col-xs-offset-3 col-xs-6 " bind-html-compile="rightPage">
                
        	 </div>
             
        	 <div class="col-lg-6  col-lg-offset-0 col-lg-offset-0 col-xs-offset-3 col-xs-6 " bind-html-compile="leftPage">
                
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