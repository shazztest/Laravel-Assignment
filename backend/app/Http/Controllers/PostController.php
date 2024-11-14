<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function createPost(Request $request){
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $post = $request->user()->posts()->create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Post Created succesfully',
            'post' => $post
        ],201);
    }

    public function getPostById(Request $request, $id){
        $post = Post::where('id',$id)->where('user_id', Auth::id())->first();
        return response()->json([
            'success' => true,
            'post' => $post,
        ],200);
    }

    public function allPosts(Request $request){
        $posts = $request->user()->posts()->get();
        return response()->json([
            'success' => true,
            'posts' => $posts
        ],200);
    }

    public function updatePosts(Request $request,$id){
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string'  
        ]);

        $post = Post::where('id',$id)->where('user_id', Auth::id())->first();

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

    public function deletePosts(Request $request,$id){
        $post = Post::where('id',$id)->where('user_id', Auth::id())->first();

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
