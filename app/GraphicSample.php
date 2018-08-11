<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Status;
use App\GraphicTag;

class GraphicSample extends Model
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

    public function graphicTags()
    {
        return $this->belongsToMany(GraphicTag::class);
    }
}
