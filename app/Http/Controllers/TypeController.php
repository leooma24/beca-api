<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = Type::where('status', 1)->get();
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
            'type' => 'required|integer',
            'shipment' => 'boolean',
            'name' => 'required|max:100',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->fails(), 500);
        }

        $record = Type::create($validator->validated());

        return response()->json($record);
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
            'type' => 'required|integer',
            'shipment' => 'boolean',
            'name' => 'required|max:100',
        ]);
        $record = Type::where('id', $id)->update($validator->validated());

        return response()->json(Type::find($id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Type::find($id);
        $record->status = 0;
        $record->save();

        return response()->json('OK');
    }
}
