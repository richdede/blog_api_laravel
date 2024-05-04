<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrUpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Craete post method
     */
    public function store(CreateOrUpdatePostRequest $request)
    {
        $validatedData = $request->validated();

        $post = new Post([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'photo' => $validatedData['photo'] ?? null,
            'user_id' => auth()->user()->id,
            'category_id' => $validatedData['category_id'] ?? null,
        ]);

        if ($post->save()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Post created successfully',
                'post' => $post
            ], 201);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Failed to create post',
            ], 500);
        }
    }

    /**
     * Update post method
     */

     public function update(CreateOrUpdatePostRequest $request, $id)
     {
        try {
            // Find the post by ID
            $post = Post::findOrFail($id);

            // Update the post attributes
            $post->title = $request->title;
            $post->description = $request->description;
            $post->photo = $request->photo ?? null;
            $post->category_id = $request->category_id ?? null;

            // Save the updated post
            $post->save();

            // Return a success response
            return response()->json([
                'status' => 'success',
                'message' => 'Post updated successfully',
                'post' => $post
            ]);
        } catch (\Exception $e) {
            // Return an error response if an exception occurs
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update post',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete post
     */

     public function destroy($id)
     {
         $post = Post::find($id);
 
         if (!$post) {
             return response()->json([
                 'status' => 'failed',
                 'message' => 'Post not found',
             ], 404);
         }
 
         $post->delete();
 
         return response()->json([
             'status' => 'success',
             'message' => 'Post deleted successfully',
         ], 200);
     }

     /**
      * Get Post
      */

      public function show($id)
      {
          $post = Post::find($id);
  
          if (!$post) {
              return response()->json([
                  'status' => 'failed',
                  'message' => 'Post not found',
              ], 404);
          }
  
          return response()->json([
              'status' => 'success',
              'post' => $post,
          ], 200);
      }


      /**
       * Get all post
       */

       public function index()
       {
           $posts = Post::all();
   
           return response()->json([
               'status' => 'success',
               'posts' => $posts,
           ], 200);
       }

       /**
        * Get by user_id
        */

        public function getByUserId(Request $request, $userId)
        {
            $posts = Post::where('user_id', $userId)->get();
    
            return response()->json([
                'status' => 'success',
                'posts' => $posts,
            ], 200);
        }

        /**
         * Get by category_id
         */

         public function getByCategoryId(Request $request, $categoryId)
         {
             $posts = Post::where('category_id', $categoryId)->get();
     
             return response()->json([
                 'status' => 'success',
                 'posts' => $posts,
             ], 200);
         }
}
