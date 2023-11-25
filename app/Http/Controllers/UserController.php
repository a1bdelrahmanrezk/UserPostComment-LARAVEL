<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\UploadImage;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;

use App\Http\Resources\UserResource;
use App\Models\Post;
use Illuminate\Support\Facades\File;
use function PHPUnit\Framework\isEmpty;

class UserController extends Controller
{
    use UploadImage;
    public function index()
    {
        $responseData = User::with('posts')->get();
        if($responseData){
            return response()->json([
                'data'=>UserResource::collection($responseData),
                'status'=>true,
                'statusCode'=>200,
                'message'=>'done',
            ]);
        }
        return response()->json([
            'status'=>false,
            'statusCode'=>404,
            'message'=>'data not found',
        ]);
    }
    public function show($id)
    {
        $responseData = User::with('posts')->find($id);
        if($responseData){
            return response()->json([
                'data'=>UserResource::make($responseData),
                'status'=>true,
                'statusCode'=>200,
                'message'=>'done',
            ]);
        }
        return response()->json([
            'status'=>false,
            'statusCode'=>404,
            'message'=>'user not found',
        ]);
    }
    public function store(UserRequest $request)
    {
        $user_path = $this->uploadImage($request,'users');
        $createdUser = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$request->password,
            'photo'=>$user_path,
        ]);
        return response()->json([
            'data'=>$createdUser,
            'status'=>true,
            'statusCode'=>200,
        ]);
    }
    public function edit(UserRequest $request, $id)
    {
        $isUserExist = User::find($id);
        if(!$isUserExist){
            return response()->json([
                'message'=>'User not found',
                'status'=>false,
                'statusCode'=>404,
            ]);
        }
        $user_path = $this->uploadImage($request,'users');
        $isUserExist->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$request->password,
            'photo'=>$user_path,
        ]);
        return response()->json([
            'data'=>$isUserExist,
            'status'=>true,
            'statusCode'=>200,
        ]);
    }
    
    public function delete($id)
    {
        $isUserExist = User::find($id);
        if(!$isUserExist){
            return response()->json([
                'message'=>'User not found',
                'status'=>false,
                'statusCode'=>404,
            ]);
        }
        $isUserExist->delete();
        return response()->json([
            'message'=>'User deleted',
            'status'=>true,
            'statusCode'=>200,
        ]);
        
    }
}
