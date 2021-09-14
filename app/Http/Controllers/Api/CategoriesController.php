<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        return response()->json(Categories::with('parents')->get());
    }

    public function store(Request $request)
    {
        Categories::create([
            'name' => $request->input('name'),
            'parent_id'   => $request->input('parent_id'),
        ]);
    }

    public function destroy(Categories $category)
    {
        $category->delete();
    }

    public function update(Request $request, Categories $category)
    {
        $category->update($request->all());
    }
}