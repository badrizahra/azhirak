<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NetworkContact extends Model
{
    protected $fillable = ['subject', 'name', 'phone', 'description'];
}