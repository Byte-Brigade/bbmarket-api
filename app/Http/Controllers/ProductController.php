<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Resources\ApiResource;
use App\Models\DetailProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new ApiResource(true, 'Product list.', Product::with('detail_products')->get());
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $request)
    {
        $input = $request->all();
        try {
            DB::beginTransaction();
            $product = Product::create([
                'seller_id' => $input['seller_id'],
                'category_id' => $input['category_id'],
                'name' => $input['name'],
                'description' => $input['description'],
            ]);

            $product->detail_products()->createMany($input['details']);

            DB::commit();
            return new ApiResource(true, 'Product has been added.', Product::with('detail_products')->find($product->id));
        } catch (Throwable $e) {
            return response()->json(['messages' => $e->getMessage()]);
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
        return new ApiResource(true, 'Get specific product.', Product::with('detail_products')->find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductStoreRequest $request, $id)
    {
        $input = $request->all();
        try {
            DB::beginTransaction();
            $product = Product::with('detail_products')->find($id);
            $product->update([
                'seller_id' => $input['seller_id'],
                'category_id' => $input['category_id'],
                'name' => $input['name'],
                'description' => $input['description'],
            ]);
            foreach ($input['details'] as $detail) {
                $product->detail_products()->updateOrCreate($detail);
            }


            DB::commit();
            return new ApiResource(true, $product->id . ' is updated', $product);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['messages' => 'Something went wrong :' . $e->getMessage()]);
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
        $product = Product::find($id);
        $product->detail_products()->delete();
        $product->delete();

        return new ApiResource(true, 'Product deleted', null);
    }
}
