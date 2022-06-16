<?php

namespace App\Http\Controllers;

use App\Http\Resources\Post as PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('q')) {
            $posts = Post::where("title", "like", "%$request->q%")
                        ->orWhere("body", "like", "%$request->q%")
                        ->get();
        } else {
            $posts = Post::get();
        }

        return response(PostResource::collection($posts), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $this->validator($request);

        if (! $validated instanceof MessageBag) {
            $post = new Post;

            $post->setValues($validated);

            $post->save();
    
            return response(new PostResource($post), 200);
        } else {
            return response($validated, 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $post = Post::where('id', $id)->first();

        return response(new PostResource($post), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $validated = $this->validator($request);

        if (! $validated instanceof MessageBag) {
            $post = Post::where('id', $id)->first();

            $post->setValues($validated);

            $post->save();
    
            return response(new PostResource($post), 200);
        } else {
            return response($validated, 422);
        }
    }

    /**
     * Custom validator.
     * 
     * @param  Request $request
     * @return \Illuminate\Support\Facades\Validator
     */
    public function validator(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'body' => 'required',
            'status' => 'in:offline,online'
        ]);
 
        if ($validator->fails()) {
            return $validator->errors();
        }

        return $validator->validated();
    }
}
