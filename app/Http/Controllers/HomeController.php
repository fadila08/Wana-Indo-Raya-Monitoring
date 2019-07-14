<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sensor;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    
    public function homePage()
    {
        $sensor = Sensor::where(DB::raw('DATE(created_at)'), DB::raw('CURDATE()'))->orderBy('id', 'desc')->get()->reverse();
        $data = [];
        $label = [];

        foreach ($sensor as $sr) {
            array_push($data, $sr->level_air);
            array_push($label, date('H:i', strtotime($sr->created_at)));
        }

        $dt = [
            'data' => $data,
            'label' => $label
        ];

        return view('home', $dt);
    }
}
