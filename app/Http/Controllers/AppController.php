<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mushaf;
use App\Surah;
use App\Juz;
use App\Ayat;
use App\Http\Requests;

class AppController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function search(Request $request){
        $searchWords = $request->input('words');
        //$searchResults = Ayat::where('aya','Like','%'.$searchWords.'%')->get();
        //dd($searchResults);
        return Ayat::where('aya','Like','%'.$searchWords.'%')->get();
    }

    public function getHTML($page) {
        $ayat = [];
        $i = 0;
        $Words = Mushaf::where('p_ID',$page)->get();
        $max = sizeof($Words);
        $num_padded = sprintf("%03d", $Words[0]->p_ID);
        $str = "<font face='QCF_P".$num_padded."'>";
        $last = $Words[$i];
        
        do {
            $current = $Words[$i];

            //new line
            if($current->l_ID > $last->l_ID)
                $str .= "<br>";
            //Make Group and set it class (title,basmalah,aya)
            if($i == 0){
                if($current->aya == 0){
                    if($current->without == 'سورة'){ //Surah Title
                        $str .= "<span class='title'>";
                        $str .= "<span id='". $Words[$i]->ID ."'>". $Words[$i]->madina ."</span>";
                        $last = $Words[$i++];
                        $current = $Words[$i];
                    } else { //Basmalah
                        $str .= "<span class='basmalah'>";
                        $str .= "<span id='". $Words[$i]->ID ."'>". $Words[$i++]->madina ."</span>";
                        $str .= "<span id='". $Words[$i]->ID ."'>". $Words[$i]->madina ."</span>";
                        $last = $Words[$i++];
                        $current = $Words[$i];
                    }
                }else{ //Aya in first line
                    $ayat = ayat::where('sura',$current->s_ID)->where('ayaNo',$current->aya)->first();
                    $sura3 = sprintf("%03d", $current->s_ID);
                    $aya3= sprintf("%03d", $current->aya);
                    $str .= "<span popover-trigger=\"'outsideClick'\" uib-popover='".$ayat->muyassar."' popover-append-to-body='true' popover-placement='auto right' id='a_".$current->aya."' class='aya' ng-class='{selected : activeMenu == \"".$sura3.$aya3."\"}' data-ng-click='activeMenu = \"".$sura3.$aya3."\"'>";
                }
            } else {

                if($current->aya == 0){ //Surah Title
                    if($current->without == 'سورة') {
                        $str .= "</span><span class='title'>";
                        $str .= "<span id='". $Words[$i]->ID ."'>". $Words[$i]->madina ."</span>";
                        $last = $Words[$i++];
                        $current = $Words[$i];
                    } else { //Basmalah
                        $str .= "</span><span class='basmalah'>";
                        $str .= "<span id='". $Words[$i]->ID ."'>". $Words[$i++]->madina ."</span>";
                        $str .= "<span id='". $Words[$i]->ID ."'>". $Words[$i]->madina ."</span>";
                        $last = $Words[$i++];
                        $current = $Words[$i];
                    }
                }else if($current->aya > $last->aya ){
                    $ayat = ayat::where('sura',$current->s_ID)->where('ayaNo',$current->aya)->first();
                    $sura3 = sprintf("%03d", $current->s_ID);
                    $aya3= sprintf("%03d", $current->aya);
                    $str .= "</span><span popover-trigger=\"'outsideClick'\" uib-popover='".$ayat->muyassar."' popover-append-to-body='true' popover-placement='auto right' id='a_".$current->aya."' class='aya'  ng-class='{selected : activeMenu == \"".$sura3.$aya3."\"}' data-ng-click='activeMenu = \"".$sura3.$aya3."\"'>";
                }
            }

            $str .= "<span id='". $current->ID ."'>". $current->madina ."</span>";
            $last = $Words[$i++];

        }while($i < $max);

        return $str.="</span></font>";
    }

    // public function saveHTML() {

    //     for ($i = 1 ; $i < 605 ; $i++) {
    //         $line7  = Mushaf::where('p_ID',$i)->where('l_ID',7)->first();
    //         $Surah  = Surah::find($line7->s_ID);
    //         $Juz    = Juz::find($line7->j_ID);
    //         $str['juz']     = $Juz->madina;
    //         $str['sura']    = $Surah->madina;
    //         $str['content'] = $this->getHTML($i);
    //         $str['page'] = $this->getArabic($i);

    //         file_put_contents("saved/".$i.".json",json_encode($str));
    //     }
    // }
    public function saveHTML() {
        $str= "";
        for ($i = 1 ; $i < 605 ; $i++) {
            $num_padded = sprintf("%03d", $i);
            $str .= "\n@font-face {
                font-family: 'QCF_P".$num_padded."';
                font-weight: normal;
                src: url('/fonts/quran/QCF_P".$num_padded.".TTF');
            }\n";

            
        }
        file_put_contents("saved/quran.Css",$str);
    }
    public function getTPages($page) {
        $rPage = $page;
        $lPage = $page + 1;
        $data['rightWords'] = $this->getHTML($rPage);
        $data['leftWords'] = $this->getHTML($lPage);
        $data['fehras'] = allFehras();
        $data['juz'] = allJuz();
    }
    public function goAya(Request $request) {
        $aya = $request->input('aya');
        $surah = $request->input('surah');
        $page = Mushaf::where('s_ID',$surah)->where('aya',$aya)->first()->p_ID;
        if(($page % 2) == 0){
            $page -=1;
        }
        $rPage = $page;
        $lPage = $page + 1;
        
        $line7R = Mushaf::where('p_ID',$rPage)->where('l_ID',7)->first();
        $line7L = Mushaf::where('p_ID',$lPage)->where('l_ID',7)->first();
        
        $data['rightWords'] = $this->getHTML($rPage);
        $data['leftWords'] = $this->getHTML($lPage);
        $data['rSurah'] = $line7R->s_ID;
        $data['lSurah'] = $line7L->s_ID;
        $data['rJuz'] = $line7R->j_ID;
        $data['lJuz'] = $line7L->j_ID;
        $data['page'] = $page;
        return $data;
    }

    public function goAyaPage(Request $request) {
        $aya = $request->input('aya');
        $surah = $request->input('surah');
        $page = Mushaf::where('s_ID',$surah)->where('aya',$aya)->first()->p_ID;
        return $page;
    }
    public function index()
    {
        //$rightWords = Mushaf::where('p_ID',1)->get();
        //$leftWords  = Mushaf::where('p_ID',2)->get();
        $rPage = 1;
        $lPage = 2;
        $data['rightWords'] = $this->getHTML($rPage);
        $data['leftWords'] = $this->getHTML($lPage);

        return $data;
    }
    
    public function turne(Request $request)
    {
        $rPage = $request->input('page');
        $lPage = $rPage + 1;
        $line7R = Mushaf::where('p_ID',$rPage)->where('l_ID',7)->first();
        $line7L = Mushaf::where('p_ID',$lPage)->where('l_ID',7)->first();
        
        $data['rightWords'] = $this->getHTML($rPage);
        $data['leftWords'] = $this->getHTML($lPage);
        $data['rSurah'] = $line7R->s_ID;
        $data['lSurah'] = $line7L->s_ID;
        $data['rJuz'] = $line7R->j_ID;
        $data['lJuz'] = $line7L->j_ID;
        return $data;
    }
    

    public function getPage(Request $request)
    {
        $rightPage  = $request->input('page');
        $data['rightWords'] = Mushaf::where('p_ID',$rightPage)->get();
        $data['leftWords']  = Mushaf::where('p_ID',$rightPage+1)->get();
        return $data;
    }
    public function getArabic($str)
    {
        $str = (string)$str;
        $western_arabic = array('0','1','2','3','4','5','6','7','8','9');
        $eastern_arabic = array('٠','١','٢','٣','٤','٥','٦','٧','٨','٩');
        return str_replace($western_arabic, $eastern_arabic, $str);
    }
    
    public function allFehras()
    {
        return Surah::all();
    }
    public function allJuz()
    {
        return Juz::all();
    }
    public function setLinePage(Request $request)
    {
     
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
