<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JengaAccount;
use Illuminate\Http\Request;
use App\Jobs\GenerateJengaToken;

class JengaAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        dispatch(new GenerateJengaToken);

        return response()->json(['message' => 'Token generated successfully']);
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
     * @param  \App\Models\JengaAccount  $jengaAccount
     * @return \Illuminate\Http\Response
     */
    public function show(JengaAccount $jengaAccount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JengaAccount  $jengaAccount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JengaAccount $jengaAccount)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JengaAccount  $jengaAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy(JengaAccount $jengaAccount)
    {
        //
    }
}
