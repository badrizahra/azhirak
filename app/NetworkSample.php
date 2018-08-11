<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Status;
use App\NetworkTag;

class NetworkSample extends Model
{
    protected $fillable = ['title', 'user_id', 'description', 'url', 'image'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function networkTags()
    {
        return $this->belongsToMany(NetworkTag::class);
    }
}
