<?php

namespace App\Http\Controllers;

use App\Models\Box;
use App\Models\Inventory;
use App\Models\InventoryMaster;
use App\Models\Presentation;
use App\Models\Scaffold;
use App\Models\Section;
use App\Models\Type;
use App\Models\Farm;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = InventoryMaster::where('status', 1)
            ->with('items')
            ->with('farm')
            ->with('type')
            ->orderBy('id', 'desc')->get();
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
        try {
            $inventory = InventoryMaster::create([
                'id_farm' => isset($request->id_farm['id']) ? $request->id_farm['id'] : NULL,
                'id_type' => $request->id_type['id'],
                'date' => $request->date,
                'customer' => $request->customer,
                'driver' => $request->driver,
                'batch' => $request->batch,
                'description' => $request->description,
            ]);

            foreach($request->items as $item) {
                $qty = $item['master'] * 10;
                $id_box = $item['id_box']['id'];

                $scaffold = Scaffold::where('name', $item['scaffold'])
                    ->where('id_box', $id_box)
                    ->first();
                if(!$scaffold) {
                    $scaffold = Scaffold::create([
                        'name' => $item['scaffold'],
                        'id_box' => $id_box,
                        'master' => $item['master'],
                        'qty' => $qty,
                        'kilograms' => $qty * $item['id_box']['kilograms']
                    ]);
                }

                $inventory->items()->create([
                    'id_farm' => isset($request->id_farm['id']) ? $request->id_farm['id'] : NULL,
                    'id_type' => $request->id_type['id'],
                    'id_box' => $id_box,
                    'id_scaffold' => $scaffold->id,
                    'id_section' => isset($item['id_section']['id']) ? $item['id_section']['id'] : NULL,
                    'date' => $request->date,
                    'type' => $request->id_type['type'],
                    'qty' => $qty,
                    'scaffold' => $item['scaffold'],
                    'master' => $item['master'],
                ]);

                Inventory::updateStock($id_box);
                $scaffold->updateStock($scaffold->items);
            }

            $inventory->items();
            $inventory->type();
            return response()->json($inventory);
        }catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
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
        $inventory =  InventoryMaster::find($id);
        $inventory->update([
            'id_farm' => isset($request->id_farm['id']) ? $request->id_farm['id'] : NULL,
            'id_type' => $request->id_type['id'],
            'date' => $request->date,
            'customer' => $request->customer,
            'driver' => $request->driver,
            'batch' => $request->batch,
            'description' => $request->description,
        ]);
        $items = collect($request->items)->pluck('id')->toArray();
        foreach($inventory->items as $item) {
            if(!in_array($item->id, $items)) {
                $id_box = $item->id_box;
                $item->delete();
                Inventory::updateStock($id_box);
            }
        }

        foreach($request->items as $item) {
            $qty = $item['master'] * 10;
            $id_box = $item['id_box']['id'];

            $scaffold = Scaffold::where('name', $item['scaffold'])
                ->where('id_box', $id_box)
                ->first();
            if(!$scaffold) {
                $scaffold = Scaffold::create([
                    'name' => $item['scaffold'],
                    'id_box' => $id_box,
                    'master' => $item['master'],
                    'qty' => $qty,
                    'kilograms' => $qty * $item['id_box']['kilograms']
                ]);
            }

            if(!isset($item['id'])) {
                $inventory->items()->create([
                    'id_farm' => isset($request->id_farm['id']) ? $request->id_farm['id'] : NULL,
                    'id_type' => $request->id_type['id'],
                    'id_box' => $id_box,
                    'id_scaffold' => $scaffold->id,
                    'id_section' => isset($item['id_section']['id']) ? $item['id_section']['id'] : NULL,
                    'date' => $request->date,
                    'type' => $request->id_type['type'],
                    'qty' => $qty,
                    'scaffold' => $item['scaffold'],
                    'master' => $item['master'],
                ]);
            } else {
                Inventory::where('id', $item['id'])->update([
                    'id_section' => isset($item['id_section']['id']) ? $item['id_section']['id'] : NULL,
                    'master' => $item['master'],
                    'qty' => $qty
                ]);
            }
            /*  calcular stock por producto*/
            Inventory::updateStock($id_box);
            $scaffold->updateStock($scaffold->items);
        }

        return response()->json(InventoryMaster::with('items')->find($id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = InventoryMaster::find($id);
        foreach($record->items as $item) {
            Inventory::updateStock($item->id_box);
            $scaffold = Scaffold::where('name', $item->scaffold)
                ->where('id_box', $item->id_box)
                ->first();
            $scaffold->updateStock($scaffold->items);
        }
        $record->items()->update(['status' => 0]);
        $record->status = 0;
        $record->save();

        return response()->json('OK');
    }

    public function getItems(Request $request) {
        $items = Inventory::where('block', $request->block)
            ->where('date', $request->date)
            ->where('status', 1)
            ->get();

        return response()->json($items);
    }

    public function checkScaffold(Request $request) {
        $item = Scaffold::where('name', $request->scaffold)
            ->first();

        return response()->json($item);
    }

    public function import(Request $request) {
        $file = $request->file('file');
        $delimiter = ',';
        $header = [];
        $count = 0;
        $data = [];
        if (($handle = fopen($file, 'r')) !== false)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
            {
                if(!$row[0] && !$row[1] && !$row[2]) continue;
                if (!$header){
                    $header = $row;
                    continue;
                }

                $count++;
                /* TYPE */
                $type = trim(ucfirst($row[0]));
                if($type == 'PRE') $type = 'Precosecha';
                if($type == '') $type = 'Cosecha';
                $typeEntity = TYPE::where('name', $type)->first();
                if($typeEntity) {
                    $row[0] = $typeEntity->id;
                } else {
                    return 'No Encontre TYPE ' . $type;
                }

                /* FARM */
                $farm = trim(ucfirst($row[1]));
                if($farm == 'X' || $farm == 'AJ') $farm = 'Ajuste';
                if($farm == 'PLAYA ORO') $farm = 'PLAYA DE ORO';
                $farmEntity = Farm::where('name', $farm)->first();
                if($farmEntity) {
                    $row[1] = $farmEntity->id;
                } else {
                    return 'No encontre FARM: ' . $farm;
                }

                /* SECTION */
                $section = trim(ucfirst($row[2]));
                $sectionEntity = Section::where('name', $section)->first();
                if($sectionEntity) {
                    $row[2] = $sectionEntity->id;
                } else {
                    if($section){
                        $sectionEntity = Section::create(['code' => $section, 'name' => $section]);
                        $row[2] = $sectionEntity->id;
                    } else {
                        $row[2] = 0;
                    }
                }

                /* SCAFFOLD */
                $scaffold = trim($row[3]);
                $row[3] = $scaffold;

                /* ENTRADAS */
                $batch = trim($row[4]);
                $inventory = InventoryMaster::where('batch', $batch)->first();
                if($inventory){
                    $row[4] = $inventory->id;
                    $inventory->update([
                        'id_type' => $typeEntity->id,
                        'id_farm' => $farmEntity->id,
                        'type' => $typeEntity->type
                    ]);
                } else {
                    $inventory = InventoryMaster::create([
                        'date' => '2021-01-01',
                        'id_type' => $typeEntity->id,
                        'id_farm' => $farmEntity->id,
                        'batch' => $batch,
                        'type' => $typeEntity->type,
                    ]);
                }
                /* ITEMS */
                /* SIZE */
                $size = trim($row[5]);
                $sizeEntity = Size::where('name', $size)->first();
                if(!$sizeEntity) {
                    $sizeEntity = Size::create([
                        'code' => strtoupper(str_replace([' ', '/'], '', $size)),
                        'name' => $size
                    ]);
                }
                $row[5] = $sizeEntity->id;

                /* PRESENTATION */
                $presentation = str_replace('C/C', 'con cabeza', trim($row[6]));
                $presentation = str_replace('S/C', 'sin cabeza', $presentation);
                $presentation = str_replace('2KGS', '', $presentation);
                $presentation = str_replace('NACNAL. FRIZ ', 'Ncnal. Frizado ', $presentation);
                $presentationEntity = Presentation::where('name', trim($presentation))->first();
                if(!$presentationEntity) {
                    return 'No encontre presentacion: ' . $presentation;
                };
                $row[6] = $presentationEntity->id;

                $box = Box::where('id_presentation', $presentationEntity->id)
                    ->where('id_size', $sizeEntity->id)
                    ->first();

                if(!$box) {
                    $box = Box::create([
                        'id_presentation' => $presentationEntity->id,
                        'id_size' => $sizeEntity->id,
                        'code' => $presentationEntity->code.$sizeEntity->code,
                        'name' => $presentationEntity->name . ' ' . $sizeEntity->name,
                        'kilograms' => '2',
                        'price' => 100,
                        'cost' => 100
                    ]);
                }

                $scaffoldEntity = Scaffold::where('name', $scaffold)
                    ->where('id_box', $box->id)
                    ->first();

                if(!$scaffoldEntity) {
                    $scaffoldEntity = Scaffold::create([
                        'name' => $scaffold,
                        'id_box' => $box->id,
                        'master' => 0,
                        'qty' => 0,
                        'kilograms' => 0
                    ]);
                }
                $master = trim($row[7]);
                $qty = trim($row[8]);

                $exist = $inventory->items()->where('id_box', $box->id)
                    ->where('scaffold', $scaffold)
                    ->where('master', $master)
                    ->first();

                if($exist) {
                    $data[] = $row;
                    continue;
                }

                $inventory->items()->create([
                    'id_farm' => $farmEntity->id,
                    'id_type' => $typeEntity->id,
                    'id_box' => $box->id,
                    'id_scaffold' => $scaffoldEntity->id,
                    'id_section' => $sectionEntity ? $sectionEntity->id : NULL,
                    'date' => '2021-01-01',
                    'type' => $typeEntity->type,
                    'qty' => $qty,
                    'scaffold' => $scaffold,
                    'master' => $master,
                ]);

                Inventory::updateStock($box->id);
                $scaffoldEntity->updateStock($scaffoldEntity->items);

            }
            fclose($handle);
        }

        return ['count' => $count, 'data' => $data];
    }
}
