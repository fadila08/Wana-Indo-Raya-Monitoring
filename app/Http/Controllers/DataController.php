<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sensor;
use App\Transformers\DataTransformers;
use App\Transformers\WaktuTransformers;
use App\Transformers\LevelAirTransformers;
use Carbon\Carbon;

class DataController extends Controller
{
    //untuk mengambil data (semua data)
    public function get(Sensor $sensor)
    {
        $no = 1;
        $sensor = $sensor->orderBy('id', 'DESC')->get();
        foreach ($sensor as $s) {
            $s['no'] = $no++;
        }
        
        return fractal()
            ->collection($sensor)
            ->transformWith(new DataTransformers)
            ->toArray();
    }

    //untuk mengambil data (satu data terbaru)
    public function getLatest(Sensor $sensor)
    {
        $sensor = $sensor->orderBy('created_at', 'DESC')->first();

        return response()->json($sensor->level_air);

        // return fractal()
        //     ->item($sensor)
        //     ->transformWith(new DataTransformers)
        //     ->toArray();
    }

    //untuk mengambil data (10 data terbaru)
    public function getTenLastWaktu(Sensor $sensor)
    {
        $sensors = $sensor->orderBy('created_at', 'DESC')->take(10)->get();

        $labels = array();
        $values = array();
        foreach ($sensors as $sensor) {
            $labels[] = $sensor->created_at->format('d-m-y H:i:s');    
            $values[] = $sensor->level_air;
        }

        $data = [
            'labels' => $labels,
            'values' => $values
        ];
        
        // $data = [
        //     $sensor[0]->created_at->format('d-m-y H:i:s'), 
        //     $sensor[1]->created_at->format('d-m-y H:i:s'), 
        //     $sensor[2]->created_at->format('d-m-y H:i:s'), 
        //     $sensor[3]->created_at->format('d-m-y H:i:s'), 
        //     $sensor[4]->created_at->format('d-m-y H:i:s'), 
        //     $sensor[5]->created_at->format('d-m-y H:i:s'), 
        //     $sensor[6]->created_at->format('d-m-y H:i:s'), 
        //     $sensor[7]->created_at->format('d-m-y H:i:s'), 
        //     $sensor[8]->created_at->format('d-m-y H:i:s'), 
        //     $sensor[9]->created_at->format('d-m-y H:i:s'), 
        // ];

        return response()->json($data);

        // return fractal()
        // ->collection($sensor)
        // ->transformWith(new WaktuTransformers)
        // ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
        // ->toArray();
    }

    //untuk mengambil data (10 data terbaru)
    public function getTenLastLevel(Sensor $sensor)
    {
        $sensor = $sensor->orderBy('created_at', 'DESC')->take(10)->get();
   
        return fractal()
        ->collection($sensor)
        ->transformWith(new LevelAirTransformers)
        ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
        ->toArray();
    }
    

    //untuk menyimpan data
    public function post(Request $request, Sensor $sensor)
    {
        $this->validate($request, [
            'level_air' => 'required',
        ]);

        $sensor = $sensor->create([
            'level_air' => $request->level_air,
        ]);

        return response()->json([
            'message' => 'data sudah tersimpan',
        ]);
    }
}
