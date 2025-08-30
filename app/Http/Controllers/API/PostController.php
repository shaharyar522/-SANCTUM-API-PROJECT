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
        $data['posts'] = Post::all();

        // return response()->json([
        //     'status' => 'true',
        //     'message' => 'All Post Data',
        //     'data' => $data,
        // ], 200);

        return $this->sendResponse($data, 'All Post Data');
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
            return $this->sendError('Valid error', $ValidateUser->errors()->all());
        };

        // Image upload handling
        if ($request->hasFile('image')) {
            $img = $request->file('image');  //get image
            $ext = $img->getClientOriginalExtension();    // get image extension like png jpg etc
            $imageName = time() . '.' . $ext;  // store img with current time + extension
            $img->move(public_path('uploads'), $imageName); // move image to uploads folder
        } else {
            $imageName = null;
        }

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

        return $this->sendResponse($post, 'Post Created Successfully');
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
        )->where(['id' => $id])->first();

        // and return json
        // return response()->json([
        //     'status' => 'true',
        //     'message' => 'Your Single Post Created Successfully',
        //     'data' => $data,
        // ], 200);

        return $this->sendResponse($data, 'Your Single Post Created Successfully');
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
            return $this->sendError('Valid error', $ValidateUser->errors()->all());
        };

        // Image upload handling
        if ($request->hasFile('image')) {
            $img = $request->file('image');  //get image
            $ext = $img->getClientOriginalExtension(); // get image extension like png jpg etc
            $imageName = time() . '.' . $ext;  // store img with current time + extension
            $img->move(public_path('uploads'), $imageName);  // move image to uploads folder
        } else {
            $imageName = null;
        }

        // update in db
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

        return $this->sendResponse($post, 'Post Update Successfully');
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
        return $this->sendResponse($post, 'Your Post has been removed Successfully');

        //Step 1: Database se us post ki image ka naam lo (jo id ke saath match karta hai).
        //Step 2: Image ka full path banao (public/uploads + image name).
        //Step 3: Us image ko server se delete karo (unlink).
        //Step 4: Post record ko database se delete karo.
        //JSON response bhejo → confirm karo ke post aur uski image successfully remove ho gayi.
    }
}
