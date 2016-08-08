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
        $words = Mushaf::where('h_ID','<',61)->where('h_ID','>=',54)->get();
        return view('page',['words' => $words]);
    }

    public function setLinePage(Request $request)
    {
        

        $from   = $request->input('from');
        $to     = $request->input('to');

        $word = Mushaf::where('ID', '>=', $from)
        ->where('ID', '<=', $to)
        ->update(['l_ID' => intval($request->input('line')),'p_ID' => intval($request->input('page'))]);
        

        
        return $to;
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
