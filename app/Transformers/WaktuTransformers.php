<?php

namespace App\Transformers;

use App\Sensor;
use League\Fractal\TransformerAbstract;

class WaktuTransformers extends TransformerAbstract
{
    public function transform(Sensor $sensor)
    {

        return [
            $sensor->created_at->format('d-m-y H:i:s')
        ];
    }
}