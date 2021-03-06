<?php

namespace App;

use Eloquent;
use Html2Text\Html2Text;
use URL;
use Auth;

class Blog extends Eloquent
{
    protected $table = 'blogs';

    protected $fillable = [
        'title', 'description', 'category_id', 'user_id', 'created_at', 'updated_at'
    ];

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function user()
    {
        return $this->belongsTo('App\User')->first();
    }

    public function category()
    {
        return $this->belongsTo('App\Category')->first()->title;
    }

    public function title()
    {
        return $this->title;
    }

    public function str_insert(&$str, $searchStr)
    {
        $pos = 0;
        if ($searchStr != null) {
            while (stripos($str, $searchStr, $pos) || (strtolower(substr($str, 0, strlen($searchStr))) == strtolower($searchStr))) {
                $pos = stripos($str, $searchStr, $pos);
                $pos1 = stripos($str, $searchStr, $pos) + strlen($searchStr);
                $str = substr_replace($str, '</strong>', $pos1, 0);
                $str = substr_replace($str, '<strong style="border-radius: 10px; background-color: rgb(255,174,169);">', $pos, 0);
                $pos += strlen('<strong style="border-radius: 10px; background-color: rgb(255,174,169);"></strong>');
            }
        }
    }


    public function printTitle()
    {
        $title = $this->title;
        if (request()->get('search') !== null) {
            $this->str_insert($title, request()->get('search'));
        }
        return $title;
    }

    public function printDescription()
    {
        $description = html_entity_decode(strip_tags($this->description));
        $description = new Html2Text($description);
        $mustShowReadMoreLink = false;
        if(mb_strlen($description->getText()) > 323){
            $mustShowReadMoreLink = true;
        }
        $description = mb_substr($description->getText(), 0, 323);
        if (request()->get('search') !== null) {
            $this->str_insert($description, request()->get('search'));
        }
        if($mustShowReadMoreLink){
            $description .= '... <a href="' . route('blogs.show', $this->permalink) . '"><strong> Read More&raquo;</strong>' . '</a>';
        }
        return $description;
    }

    public function dateCreated()
    {
        return $this->created_at->format('j M, Y');
    }

    public function timeCreated()
    {
        return $this->created_at->format('H:i');
    }

    public function categoryName()
    {
        return Category::find($this->category_id)->title;
    }

    public function commentsNumber()
    {
        return count($this->comments()->get());
    }

}
