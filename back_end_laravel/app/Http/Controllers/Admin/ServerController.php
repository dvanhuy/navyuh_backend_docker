<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Sanctum\PersonalAccessToken;

class ServerController extends Controller
{
    public function index(){
        return response(Server::all());
    }
    public function store(Request $request){
        $tokenn = PersonalAccessToken::findToken($request->bearerToken());
        $user = $tokenn->tokenable;
        $createrq = $request->validate([
            'name' => 'required|string',
            'password' => 'string|nullable',
            'description' => 'string|nullable',
        ]);

        $createrq['idcreator'] = $user['id'];

        $server = Server::create($createrq);
        if (!$server){
            return response([
                'message'=>'Có lỗi khi tạo server'
            ],Response::HTTP_NOT_IMPLEMENTED);   
        }
        return response($server)->setStatusCode(201);   
    }
    public function show(){
        
    }
    public function update(){
        
    }
    public function destroy(){
        
    }
}
