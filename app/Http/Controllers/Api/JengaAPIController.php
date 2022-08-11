<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JengaAccount;
use Illuminate\Http\Request;

class JengaAPIController extends Controller
{
    /**
     * Check Account Balance.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return accountOpeningClosingBalance('KE', '0011547896523', '2019-01-31');
    }

}
