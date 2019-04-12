<?php

namespace App\Http\Controllers;

use App\Blog;
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
            'image' => 'required|mimes:jpeg,bmp,png|dimensions:min_width=50,min_height=100',
        ]);
        $filename = Auth::user()->name . '-' . md5(Auth::user()->id);
        $ext = '.' . $request->file('image')->getClientOriginalExtension();

        if (Auth::user()->avatar !== null && File::exists('uploads/avatars/' . Auth::user()->avatar)) {
            unlink('uploads/avatars/' . Auth::user()->avatar);
        }

        $img = Image::make(Input::file('image'));

        $width = $img->width();
        $height = $img->height();
        $max_width = 200;
        $max_height = 200;
        $ar = ($width / $max_width < $height / $max_height) ? ($width / $max_width) : ($height / $max_height);
        $nw = round($width / $ar);
        $nh = round($height / $ar);
        $new_size = $nw < $nh ? $nw : $nh;
        $img->resize($nw, $nh);
        $img->resizeCanvas($new_size, $new_size, 'top', false, 'ffffff');
        $img->save('uploads/avatars/' . $filename . $ext);

        $user = Auth::user();
        $user->avatar = $filename . $ext;
        $user->update();

        return redirect()->route('profile')->with(['message' => 'Successfully uploaded profile picture.']);
    }

    public function index()
    {
        return view('admin.users')->with('users', User::all());
    }

    public function store(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|min:3|max:15|unique:users,name,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|same:password-confirmation',
            'password-confirmation' => 'nullable|same:password',
            'status' => 'required',
        ]);

        $user = User::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if ($request->input('password') !== null) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->status = $request->input('status');
        $user->update();

        return redirect()->route('users')->with(['message' => 'User was successfully updated']);
    }

    public function show()
    {
        return view('profile');
    }

    public function show1($user)
    {
        return view('profile1')->with('user', User::where('name', $user)->first());
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
        if ($request->input('password') !== null) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->updated_at = Carbon::now();
        $user->save();
        return redirect()->route('profile')->with(['message' => 'User was successfully updated']);
    }

    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->route('users')->with(['message' => 'User was successfully deleted']);
    }

    public function activity($id)
    {
        $user = User::find($id);

        $user_posts = Blog::
        select('blogs.*', 'categories.title as category')
            ->leftJoin('categories', 'categories.id', '=', 'blogs.category_id')
            ->where('blogs.user_id', $id)
            ->get();

        $user_comments = User::
        select('comments.*', 'blogs.title', 'blogs.permalink')
            ->leftJoin('comments', 'comments.user_id', '=', 'users.id')
            ->where('comments.user_id', '=', $id)
            ->leftJoin('blogs', 'blogs.id', '=', 'comments.blog_id')
            ->get();
        return view('admin.users-activity')->with(['user' => $user, 'user_posts' => $user_posts, 'user_comments' => $user_comments]);
    }
}
