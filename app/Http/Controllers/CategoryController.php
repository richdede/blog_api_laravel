<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        
        return response()->json([
            'status' => 'success',
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|unique:categories|max:255'
        ]);
    
        try {
            // Attempt to create a new category
            $category = Category::create([
                'name' => $request->name
            ]);
    
            // Return a success response if the category was created successfully
            return response()->json([
                'status' => 'success',
                'message' => 'Category created successfully',
                'category' => $category
            ], 201);
        } catch (\Exception $e) {
            // Return an error response if an exception occurs during category creation
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create category',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
}
