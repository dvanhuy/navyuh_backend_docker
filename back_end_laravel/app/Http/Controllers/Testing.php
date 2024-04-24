<?php

namespace App\Http\Controllers;

use App\Models\OTP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class Testing extends Controller
{
    // http://localhost:8000/dd-variable
    public function ddVariable()
    {
        $result = DB::table('categorys')->get();
        dd($result);
    }
    public function ddrequest(Request $request)
    {
        dd($request);
    }
}
