<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    public function all()
    {
        $products = Product::with('categories')->get();
        return response()->json($products, 200);
    }

    public function ProductProfile($slug)
    {
        $product = Product::where('slug', $slug)->with('categories')->first();
        return response()->json($product, 200);
    }

    public function update(ProductRequest $request)
    {
        # find the product
        $product = Product::find($request->safe()->id);

        #once found, update the record
        $product->update([
            'name' => $request->safe()->name,
            'slug' => $this->uniqueSlug($request->safe()->name),
            'description' =>$request->safe()->description,
            'itemUnit' => $request->safe()->itemUnit
        ]);

        //categories is not empty
        if(count($request->categories) > 0) {
            $product->categories()->detach(); //detach or remove all the record in the pivot before inserting the new set of record.

            //loop the category
            foreach($request->categories as $key => $category)
            {
                $product->categories()->attach($category['id']);
            }
        }

        return response()->json($product, 200);
    }

    public function save(ProductRequest $request)
    {
        $product = Product::create([
            'name' => $request->name,
            'slug' => $this->uniqueSlug($request->name),
            'description' =>$request->description,
            'itemUnit' => $request->itemUnit
        ]);

        //categories is not empty
        if(count($request->categories) > 0) {
            $product->categories()->detach(); //detach or remove all the record in the pivot before inserting the new set of record.

            //loop the category
            foreach($request->categories as $key => $category)
            {
                $product->categories()->attach($category['id']);
            }
        }
        return response()->json($product, 200);
    }

    public function delete($id)
    {
        $product = Product::find($id);

        if($product)
        {
            $product->delete($id);
            return response()->json(true, 200);
        }

        return response()->json(false);
    }

    public function uniqueSlug($name)
    {
        $slug = Str::slug($name);
        $count = Product::where('slug', $slug)->count();
        // $count = Product::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
        return $count > 0 ? $slug.'-'.strtotime(now()) : $slug;
    }

}
