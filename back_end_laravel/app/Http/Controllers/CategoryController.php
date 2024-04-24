<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\PersonalAccessToken;

class CategoryController extends Controller
{
    public function index(Request $request){
        return response(DB::table('categorys')->get());
    }
    public function store(){
        
    }
    public function show(){
        
    }
    public function update(){
        
    }
    public function destroy(){
        
    }

}
