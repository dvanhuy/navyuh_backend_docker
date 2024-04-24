<?php

namespace App\Http\Controllers;

use App\Models\JoiningDetails;
use App\Models\Server;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\PersonalAccessToken;

class UserServerController extends Controller
{
    public function index(Request $request)
    {
        $user = new User();
        $user = $user->getUserFromToken($request);
        $servers = JoiningDetails::where('id_user', $user['id'])->get();
        return response($servers);
        // return response(Server::all());
    }

    public function show(Server $idserver)
    {
        return response($idserver);
    }

    public function join(Request $request,Server $idserver)
    {
        $user = new User();
        $user = $user->getUserFromToken($request);
        $join = DB::table('joining_details')
        ->where('id_user',$user->id)
        ->where('id_server',$idserver->id)
        ->first();

        if ($join){
            return response([
                'message'=>'Đã tham gia vào server rồi'
            ],303); 
        }
        
        $check = JoiningDetails::create([
            'id_user' => $user->id,
            'id_server' =>  $idserver->id,
        ]);
        
        if ($check){
            return response([
                'message'=>'Đã tham gia vào server'
            ]);
        }

        return response([
            'message'=>'Đã tham gia vào server'
        ],422);
    }
    
}
