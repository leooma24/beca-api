<?php

namespace App\Http\Controllers;

use App\Models\Box;
use App\Models\Scaffold;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BoxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = Box::where('status', 1)->get();
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
            'id_size' => 'required',
            'id_presentation' => 'required',
            'code' => 'required|max:100',
            'name' => 'required|max:100',
            'kilograms' => 'required',
            'price' => 'required|numeric',
            'cost' => 'numeric',
            'description' => 'max:500',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 500);
        }

        $record = Box::create($validator->validated());

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
            'id_size' => 'required',
            'id_presentation' => 'required',
            'code' => 'required|max:100',
            'name' => 'required|max:100',
            'kilograms' => 'required',
            'price' => 'required|numeric',
            'cost' => 'numeric',
            'description' => 'max:500',
        ]);
        $record = Box::where('id', $id)->update($validator->validated());

        return response()->json(Box::find($id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Box::find($id);
        $record->status = 0;
        $record->save();

        return response()->json('OK');
    }

    public function getScaffolds(Request $request) {
        $rows = Scaffold::where('id_box', $request->id)
            ->get();
        return response()->json($rows);
    }
}
