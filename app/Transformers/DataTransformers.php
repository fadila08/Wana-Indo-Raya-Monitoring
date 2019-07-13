<?php

namespace App\Transformers;

use App\Sensor;
use League\Fractal\TransformerAbstract;

class DataTransformers extends TransformerAbstract
{
    public function transform(Sensor $sensor)
    {
        return [
            $sensor->no,
            $sensor->created_at->format('l, d F Y H:i:s'),
            $sensor->level_air,
        ];
    }
}