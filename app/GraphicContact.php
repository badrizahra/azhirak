<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GraphicContact extends Model
{
    protected $fillable = ['subject', 'name', 'phone', 'description'];
}
