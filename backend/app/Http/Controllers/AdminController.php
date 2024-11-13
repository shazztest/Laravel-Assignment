<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Post;
use App\Models\User;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'admin']);
    }

    public function getAllUsers(){
        $users = User::all();
        return response()->json(['users'=>$users],201);
    }

    public function getAllRoles(){
        $roles = Role::all();
        return response()->json(['roles'=>$roles],201);
    }

    public function getAllPosts(){
        $posts = Post::all();
        return response()->json(['posts'=>$posts],201);
    }

    public function getCreatePosts(Request $request){
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string'
        ]);

        $post = $request->user()->posts()->create([
            'title' => $request->title,
            'description' => $request->description
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Post Created...!',
            'post' => $post
        ],201);
    }

    public function getUpdatePosts(Request $request,$id){
        $reques->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string'  
        ]);

        $post = Post::where('id',$id)->first();
        if(!$post){
            return response()->json([
                'success' => false,
                'message' => 'Post not found',
            ],402);
        }

        $post->update([
            'title' => $request->title,
            'description' => $request->description
        ]);
        return response()->json([
            'success' => true,
            'posts' => $post
        ],200);
    }

    public function getDeletePosts(Request $request,$id){
        $post = Post::where('id',$id)->first();

        if(!$post){
            return response()->json([
                'success' => false,
                'message' => 'Post not found',
            ],402);
        }

        $post->delete();
        return response()->json([
            'success' => true,
            'message' => 'Post deleted...!!',
        ],200);
    }
}
