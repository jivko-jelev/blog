<?php
/**
 * Created by PhpStorm.
 * User: blade
 * Date: 26.07.17
 * Time: 00:33
 */

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Intervention\Image\Facades\Image;


class Functions
{

    public static function proba()
    {

    }

    public static function copy($str, $start, $searchStr)
    {
        $str = strtolower($str);
        for ($i=$start;$i<strlen($str);$i++){
            if($str[$i] == $searchStr){
                return substr($str, $start, $i);
                break;
            }
        }
        return strtolower($str);
    }

    public static function imgResizer($src, $dst , $neww, $newh, $quality, $change_extension = null)
    {
        $folder=self::getFolder($dst);
        if(!File::isDirectory($folder)){
            File::makeDirectory('.' . $folder, 0777, true);
        }
        if(!File::copy($src, $dst)){
            die("Couldn't copy file");
        }
        $image=Image::make('./'.$dst);
        $w = $image->width();
        $h = $image->height();
        $image->crop(30,30);
        $aspect = max($image->width() / $w, $image->height() / $h);
        $image->resize($image->width() / $aspect, $image->height() / $aspect);
    }

    public static function withPath()
    {
        $dd1=[];
        foreach (explode('&', request()->getQueryString()) as $value){
            if((strlen(substr($value, 0, strpos($value, '='))) + 1 < strlen($value))) {
                if (substr($value, 0, strpos($value, '=')) != 'page') {
                    $dd1[] = $value;
                }
            }
        }
        return '?' . implode('&', $dd1);
    }

    public static function humanReadableDateTime($dt)
    {
        return Carbon::create($dt->format('Y'), $dt->format('n'), $dt->format('j'), $dt->format('H'), $dt->format('i'), $dt->format('s'))->diffforhumans();
    }


    public static function isActiveCurrentUri($parameter)
    {
        if(request()->routeIs('blogs.order1')){
            if(Category::where('title', Route::current()->parameters()[Route::current()->parameternames()[0]])->first()->title == $parameter){
                return ' active';
            }
        }
        if(request()->routeIs('blogs.show')){
            if(Blog::find(Route::current()->parameters()[Route::current()->parameternames()[0]])->category() == $parameter){
                return ' active';
            }
        }
    }
}