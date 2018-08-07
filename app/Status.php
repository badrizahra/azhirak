<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\WebSample;

class Status extends Model
{
    public function WebSamples()
    {
        return $this->hasMany(WebSample::class);
    }
}
