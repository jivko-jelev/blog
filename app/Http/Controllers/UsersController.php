<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Input;
use URL;
use Carbon\Carbon;
use File;
use Image;
use App\User;

class UsersController extends Controller
{

    public function avatar(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|mimes:jpeg,bmp,png|dimensions:min_width=100,min_height=200',
        ]);
        $filename = Auth::user()->name;
        $ext = '.' . $request->file('image')->getClientOriginalExtension();

        if(Auth::user()->avatar !== null && File::exists('uploads/avatars/' . Auth::user()->avatar)){
            unlink('uploads/avatars/' . Auth::user()->avatar);
        }


        $img=Image::make(Input::file('image'));

        $width = $img->width();
        $height = $img->height();
        $max_width = 320;
        $max_height = 200;
        $ar = ($width / $max_width > $height / $max_height) ? ($width / $max_width) : ($height / $max_height) ;
        $nw = $width / $ar;
        $nh = $height / $ar;
        $img->resize(round($width / $ar), round($height / $ar));
        $img->resizeCanvas(round($nw), round($nh), 'center', false, 'ffffff');
        $img->save('uploads/avatars/' . $filename . $ext);

        $user = Auth::user();
        $user->avatar = $filename . $ext;
        $user->update();

        return redirect()->route('profile')->with(['message' => 'Successfully uploaded profile picture.']);
    }

    public function index()
    {
        return view('admin-users')->with('users', User::all());
    }

    public function create()
    {
        //
    }

    public function store(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|min:3|max:15|unique:users,name,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'status' => 'required',
        ]);

        $user=User::find($id);
        $user->name=$request->input('name');
        $user->email=$request->input('email');
        $user->status=$request->input('status');
        $user->update();

        return redirect()->route('admin-users')->with(['message' => 'User was successfully updated']);
    }

    public function show()
    {
        return view('profile');
    }

    public function show1($user)
    {
        return view('profile1')->with('user', User::where('name', $user)->first());
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|min:3|max:50|unique:users,email,' . Auth::user()->id,
            'password' => 'nullable|same:password_confirmation',
            'password_confirmation' => 'nullable|same:password',
        ]);

        $user = Auth::user();
        $user->email = $request->input('email');
        if($request->input('password') !== null){
            $user->password = bcrypt($request->input('password'));
        }
        $user->updated_at= Carbon::now();
        $user->save();
        return redirect()->route('profile')->with(['message' => 'User was successfully updated']);
    }

    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->route('admin-users')->with(['message' => 'User was successfully deleted']);
    }
}
