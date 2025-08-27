<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['$post'] = Post::all();

        return response()->json([
            'status' => 'true',
            'message' => 'All Post Data',
            'data' => $data,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {

        $ValidateUser = Validator::make(
            $request->all(),
            [
                'title' => 'required',
                'description' => 'required|email|unique:users,email',
                'image' => 'required|mimes:png,jpg,jpeg,gif',
            ]
        );

        //agr fail hn gyi request
        if ($ValidateUser->fails()) {
            return response()->json([
                'status' => 'false',
                'message' => 'invalide users login',
                'error' => $ValidateUser->errors()->all(),
            ], 401);
        };
        $post = Post::select('id', 'image')->get();

        if($request->image  != ''){
            
        }

        $img = $request->image;  //get image
        $ext = $img->getClientOriginlExtention();    // get image extentionl like png jpg etc
        $imageName = time() . '.' . $ext;  // store img with current time + extention
        $img->move(public_path() . '/uploads' . $imageName);  //move imag with origin extention name




        // otherwise store in db
        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imageName,
        ]);


        // and return json
        return response()->json([
            'status' => 'true',
            'message' => 'Post Created Successfully',
            'user' => $post,
        ], 200);
    }

    /**
     * Display the specified resource.
     */

    public function show(string $id)
    {
        $data['post'] = Post::select(
            'id',
            'title',
            'description',
            'image',
        )->where(['id' => $id])->get();

        // and return json
        return response()->json([
            'status' => 'true',
            'message' => 'Your Single Post Created Successfully',
            'data' => $data,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $ValidateUser = Validator::make(
            $request->all(),
            [
                'title' => 'required',
                'description' => 'required|email|unique:users,email',
                'image' => 'required|mimes:png,jpg,jpeg,gif',
            ]
        );

        //agr fail hn gyi request
        if ($ValidateUser->fails()) {
            return response()->json([
                'status' => 'false',
                'message' => 'invalide users login',
                'error' => $ValidateUser->errors()->all(),
            ], 401);
        };


        $img = $request->image;  //get image
        $ext = $img->getClientOriginlExtention(); // get image extentionl like png jpg etc
        $imageName = time() . '.' . $ext;  // store img with current time + extention
        $img->move(public_path() . '/uploads' . $imageName);  //move imag with origin extention name




        // otherwise store in db
        $post = Post::where(['id' => $id])->update([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imageName,
        ]);


        // and return json
        return response()->json([
            'status' => 'true',
            'message' => 'Post Created Successfully',
            'user' => $post,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
