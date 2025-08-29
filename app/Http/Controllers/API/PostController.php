<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;

class PostController extends BaseController
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['$posts'] = Post::all();

        // return response()->json([
        //     'status' => 'true',
        //     'message' => 'All Post Data',
        //     'data' => $data,
        // ], 200);

        return  $this()->sendResponce($data, 'All Post Data');
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
                'description' => 'required',
                'image' => 'required|mimes:png,jpg,jpeg,gif',
            ]
        );

        //agr fail hn gyi request
        if ($ValidateUser->fails()) {
            // return response()->json([
            //     'status' => 'false',
            //     'message' => 'invalide users login',
            //     'error' => $ValidateUser->errors()->all(),
            // ], 401);

            //or Short code
            return  $this()->sendError('Valid error', $ValidateUser->errors()->all());
        };


        //agr image upload kr rahi k tu pahli wali ko remove kr dain 
        // or agr  nhi kr rahki tu pahlay wali image ko remove kr dain 
        $post = Post::select('id', 'image')->first();
        if ($request->image  != '') {

            $path = public_path() . '/uploads';



            $img = $request->image;  //get image
            $ext = $img->getClientOriginalExtension();    // get image extentionl like png jpg etc
            $imageName = time() . '.' . $ext;  // store img with current time + extention
            $img->move(public_path('/uploads'), $imageName);
            //move imag with origin extention name
        } else {
            $imageName = $post->image;
        }

        // Agar new image aayi hai:
        // Uska extension lo (jpg, png, etc).
        // Ek unique naam banao (time() + extension).
        // Image ko public/uploads folder me move kar do.
        // Roman Urdu Flow (Easy Summary)
        // Post ko DB se nikaalo.
        // Check karo new image upload hui hai?
        // Agar hui hai → purani image delete karo → new image uploads folder me save karo.
        // Agar nahi hui → purani image ka naam rehne do.
        // DB me image ka naam update karke save kar do


        // otherwise store in db
        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imageName,
        ]);


        // and return json
        // return response()->json([
        //     'status' => 'true',
        //     'message' => 'Post Created Successfully',
        //     'user' => $post,
        // ], 200);

        return  $this()->sendResponce($post, 'Post Created Successfully');
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
        // return response()->json([
        //     'status' => 'true',
        //     'message' => 'Your Single Post Created Successfully',
        //     'data' => $data,
        // ], 200);

        return  $this()->sendResponce($data, 'Your Single Post Created Successfully');
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
                'description' => 'required',
                'image' => 'required|mimes:png,jpg,jpeg,gif',
            ]
        );


        //agr fail hn gyi request
        if ($ValidateUser->fails()) {
            // return response()->json([
            //     'status' => 'false',
            //     'message' => 'invalide users login',
            //     'error' => $ValidateUser->errors()->all(),
            // ], 401);
            return  $this()->sendError('Valid error', $ValidateUser->errors()->all());
        };


        $img = $request->image;  //get image
        $ext = $img->getClientOriginalExtension(); // get image extentionl like png jpg etc
        $imageName = time() . '.' . $ext;  // store img with current time + extention
        $img->move(public_path() . '/uploads' . $imageName);  //move imag with origin extention name




        // otherwise store in db
        $post = Post::where(['id' => $id])->update([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imageName,
        ]);


        // and return json
        // return response()->json([
        //     'status' => 'true',
        //     'message' => 'Post Update Successfully',
        //     'user' => $post,
        // ], 200);

        return  $this()->sendResponce($post, 'Post Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $post = Post::find($id);

        // Agar post hi nahi mili
        if (!$post) {
            return response()->json([
                'status' => 'false',
                'message' => 'Post not found',
            ], 404);
        }

        // Agar image exist karti hai to delete karo
        if ($post->image) {
            $filepath = public_path('uploads/' . $post->image);
            if (file_exists($filepath)) {
                unlink($filepath);
            }
        }

        // DB se post delete karo
        $post->delete();

        // return response()->json([
        //     'status' => 'true',
        //     'message' => 'Your Post has been removed Successfully',

        // ], 200);
        return  $this()->sendResponce($post, 'Your Post has been removed Successfully');

        //Step 1: Database se us post ki image ka naam lo (jo id ke saath match karta hai).
        //Step 2: Image ka full path banao (public/uploads + image name).
        //Step 3: Us image ko server se delete karo (unlink).
        //Step 4: Post record ko database se delete karo.
        //JSON response bhejo → confirm karo ke post aur uski image successfully remove ho gayi.

    }
}
