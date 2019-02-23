<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'admin', 'status', 'gender'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isAdmin()
    {
        return $this->admin;
    }

    public function isBlocked()
    {
        return $this->status == 255;
    }

    public function blog()
    {
        return $this->hasMany('App\Blog');
    }

    public function comment()
    {
        return $this->hasMany('App\Comment');
    }

    public function dateCreated()
    {
        return $this->created_at->format('j M, Y');
    }
}
