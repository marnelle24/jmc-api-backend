<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    public function all()
    {
        $categories = Category::all();
        return response()->json($categories, 200);
    }

    public function CategoryProfile($slug)
    {
        $category = Category::where('slug', $slug)->first();
        return response()->json($category, 200);
    }

    public function update(CategoryRequest $request)
    {
        # find the category
        $category = Category::find($request->id);

        #once found, update the record
        $category->update([
            'name' => $request->safe()->name,
            'slug' => $this->uniqueSlug($request->safe()->name),
            'description' =>$request->safe()->description,
        ]);

        return response()->json($category, 200);
    }

    public function save(CategoryRequest $request)
    {
        $category = Category::create([
            'name' => $request->safe()->name,
            'slug' => $this->uniqueSlug($request->safe()->name),
            'description' =>$request->safe()->description,
        ]);

        return response()->json($category, 200);
    }

    public function delete($id)
    {
        $category = Category::find($id);

        if($category)
        {
            $category->delete($id);
            return response()->json(true, 200);
        }

        return response()->json(false);
    }

    public function uniqueSlug($name)
    {
        $slug = Str::slug($name);
        $count = Category::where('slug', $slug)->count();
        return $count > 0 ? $slug.'-'.strtotime(now()) : $slug;
    }

}
