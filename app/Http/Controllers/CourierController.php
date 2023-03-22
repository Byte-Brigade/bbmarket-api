<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourierStoreRequest;
use App\Http\Resources\ApiResource;
use App\Models\Courier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new ApiResource(true, 'Show couriers.', Courier::get());
    }

    /**
     * Display orders by courier
     *
     * @return \Illuminate\Http\Response
     */
    public function ordersByCourier($id)
    {

        $courier = Courier::with('orders')->find($id);
        $orders = $courier->orders()->get();
        return new ApiResource(true, 'Orders list by courier.', $orders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourierStoreRequest $request)
    {
        $input = $request->all();
        try {
            DB::beginTransaction();
            $courier = Courier::create($input);
            DB::commit();
            return new ApiResource(true, 'Courier has been stored.', $courier);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['messages' => 'Something went wrong :' . $e->getMessage()]);
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
        return new ApiResource(true, 'Show specific courier.', Courier::find($id));
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
            $courier = Courier::find($id);
            $courier->update($input);
            DB::commit();
            return new ApiResource(true, 'Courier has been updated.', $courier);
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
        $courier = Courier::find($id);
        $courier->delete();

        return new ApiResource(true, 'Courier has been deleted.', null);
    }
}
