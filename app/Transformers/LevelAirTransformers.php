<?php

namespace App\Transformers;

use App\Sensor;
use League\Fractal\TransformerAbstract;

class LevelAirTransformers extends TransformerAbstract
{
    public function transform(Sensor $sensor)
    {

        return [
            $sensor->level_air
        ];
    }
}