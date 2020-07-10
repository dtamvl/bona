<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
	protected $table = 'tags';
    protected $guarded = ['']; //không bảo vệ trường nào, có thể update

    public function posts()
    {
        return $this->belongsToMany('App\Post')->withTimestamps();
    }
}
