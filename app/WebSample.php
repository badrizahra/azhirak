<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class WebSample extends Model
{
    protected $fillable = ['title', 'user_id', 'description', 'url', 'image'];

    public function user() 
	{
		return $this->belongsTo(User::class);
	}
}
