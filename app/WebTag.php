<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\WebSample;

class WebTag extends Model
{
    public function webSamples()
    {
        return $this->belongsToMany(WebSample::class);
    }
}
