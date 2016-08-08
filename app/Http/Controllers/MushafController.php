<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mushaf;
use App\Http\Requests;

class MushafController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$rightWords = Mushaf::where('p_ID',3)->get();
        //$leftWords  = Mushaf::where('p_ID',4)->get();
        //return view('index',['leftWords' => $leftWords,'rightWords' => $rightWords]);
        return view('app');
    }
    public function getPage(Request $request)
    {
        $rightPage  = $request->input('page');
        $data['rightWords'] = Mushaf::where('p_ID',$rightPage)->get();
        $data['leftWords']  = Mushaf::where('p_ID',$rightPage+1)->get();
        return $data;
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
