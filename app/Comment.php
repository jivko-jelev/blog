<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Eloquent;
use URL;

class Comment extends Eloquent
{
    protected $table = 'comments';

    protected $fillable = [
        'message', 'user_id', 'blog_id', 'created_at',
    ];


    public function authorName()
    {
        return User::find($this->user_id)->name;
    }

    public function dateCreated()
    {
        return $this->created_at->format('j M, Y');
    }

    public function timeCreated()
    {
        return $this->created_at->format('H:i');
    }
}
