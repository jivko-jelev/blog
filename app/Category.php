<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Eloquent;
use Illuminate\Support\Facades\DB;

class Category extends Eloquent
{
    protected $table = 'categories';

    protected $fillable = [
        'title', 'parent_id',
    ];

    public function blogs()
    {
        return $this->hasMany('App\Blog');
    }

}
