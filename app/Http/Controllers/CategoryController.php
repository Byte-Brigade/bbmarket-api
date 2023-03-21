<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStoreRequest;
use App\Http\Resources\ApiResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new ApiResource(true, 'Show categories.', Category::get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryStoreRequest $request)
    {
        $input = $request->all();
        try {
            DB::beginTransaction();
            $category = Category::create($input);
            DB::commit();
            return new ApiResource(true, 'Category has been created', $category);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['messages' => 'Something went wrong ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new ApiResource(true, 'Show specific category', Category::find($id));
    }

    /**
     * Display products by category
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function productsByCategory($id)
    {
        $category = Category::with('products')->find($id);
        $products = $category->products()->get();
        return new ApiResource(true, 'Show products by category', $products);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        try {
            DB::beginTransaction();
            $category = Category::find($id);
            $category->update($input);
            DB::commit();
            return new ApiResource(true, 'Category has been updated', $category);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['messages' => 'Something went wrong ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        return new ApiResource(true, 'Category has been deleted.', null);
    }
}
