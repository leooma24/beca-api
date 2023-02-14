<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\StoreHouse;

class StoreHouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = StoreHouse::where('status', 1)->get();
        return response()->json($rows);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:100',
            'name' => 'required|max:100',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->fails(), 500);
        }

        $company = StoreHouse::create($validator->validated());

        return response()->json($company);
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
        $validator = Validator::make($request->all(), [
            'code' => 'required|max:100',
            'name' => 'required|max:100',
        ]);
        $record = StoreHouse::where('id', $id)->update($validator->validated());

        return response()->json(StoreHouse::find($id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = StoreHouse::find($id);
        $record->status = 0;
        $record->save();

        return response()->json('OK');
    }
}
