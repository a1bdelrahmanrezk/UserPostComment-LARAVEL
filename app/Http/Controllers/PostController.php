<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $responseData = Post::with('user')->get();
    if($responseData){
        return response()->json([
            'data'=>PostResource::collection($responseData),
            'status'=>true,
            'statusCode'=>200,
            'message'=>'done',
        ]);
    }
    return response()->json([
        'message'=>'No Posts Found',
        'status'=>false,
        'statusCode'=>404,
    ]);
    }

    public function show($id)
    {
        $responseData = Post::with('user')->find($id);
        if($responseData){
            return response()->json([
                'data'=>PostResource::make($responseData),
                'status'=>true,
                'statusCode'=>200,
                'message'=>'done',
            ]);
        }
        return response()->json([
            'message'=>'No Posts Found',
            'status'=>false,
            'statusCode'=>404,
        ]);
    }
    public function store(PostRequest $request)
    {
        $createdPost = Post::create([
            'title'=>$request->title,
            'description'=>$request->description,
            'author'=>$request->author,
        ]);
        return response()->json([
            'data'=>$createdPost,
            'status'=>true,
            'statusCode'=>200,
        ]);
    }
    public function edit(PostRequest $request,$id)
    {
        $isPostExist = Post::find($id);
        if(!$isPostExist){
            return response()->json([
                'message'=>'Post not found',
                'status'=>false,
                'statusCode'=>404,
            ]);
        }
        $isPostExist->update([
            'title'=>$request->title,
            'description'=>$request->description,
            'author'=>$request->author,
        ]);
        return response()->json([
            'data'=>$isPostExist,
            'status'=>true,
            'statusCode'=>200,
        ]);
    }
    public function delete($id)
    {
        $isPostExist = Post::find($id);
        if(!$isPostExist){
            return response()->json([
                'message'=>'Post not found',
                'status'=>false,
                'statusCode'=>404,
            ]);
        }
        $isPostExist->delete();
        return response()->json([
            'message'=>'Post deleted',
            'status'=>true,
            'statusCode'=>200,
        ]);
    }
}
