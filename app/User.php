<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;
use Illuminate\Support\Facades\URL;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'admin', 'status', 'gender'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
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

    public function avatar()
    {
        return $this->avatar != null ? '<img src="' . URL::to('uploads/avatars/' . $this->avatar) . '" class="avatar-admin">' : '<span><i class="fa fa-user fa-3x"></i></span>';
    }

}
