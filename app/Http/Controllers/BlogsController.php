<?php

namespace App\Http\Controllers;

use App\Category;
use App\Blog;
use Auth;
use DB;
use App\Functions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\VarDumper\Cloner\Data;


class BlogsController extends Controller
{

    public function create()
    {
        return view('create-post');
    }

    public static function isRepeatingPermalink($objects, $str)
    {
        foreach ($objects as $obj) {
            if ($obj->permalink === $str) {
                return true;
            }
        }
        return false;
    }

    public static function getUniquePermalink($title)
    {
        $title = mb_strtolower($title);
        if (Blog::where('permalink', $title)->get()->count() == 0) {
            return $title;
        }
        $categories = Blog::where('permalink', 'like', $title . '%')->get();
        $count = 1;
        while ((self::isRepeatingPermalink($categories, $title . '-' . ++$count))) {
        }
        return $title . '-' . $count;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'category' => 'required',
            'title' => 'required|min:3|max:100',
            'description' => 'required|max:1165535',
        ]);

        $blog = new Blog;
        $blog->category_id = $request->input('category');
        $blog->title = $request->input('title');
        $blog->description = $request->input('description');
        $blog->permalink = mb_strtolower(urlencode(self::getUniquePermalink($request['title'])));
        $blog->user_id = Auth::id();
        $blog->updated_at = null;
        $blog->save();

        $categoryName = Category::find($blog->category_id)->title;

        return redirect('category/' . strtolower($categoryName))->with('message', 'Successfully created post');
    }

    public function show($id)
    {
        $blog = Blog::where('permalink', urldecode($id))->first();
//        dd($blog);
        return view('post')->with(['blog' => $blog, 'category_title' => Category::find($blog->category_id)->title]);
    }

    public function search(Request $request, $category = null)
    {
        $orderBy = $request->get('order-by') == null || $request->get('order-by') == 'New Posts' ? 'desc' : 'asc';
        $category_id = $category !== null ? Category::where('title', $category)->first()->id : null;
        $blogs = null;
        if ($request->get('order-by') == 'Most Commented') {
            $blogs = Blog::
            select('blogs.*', DB::raw('count(comments.blog_id) as user_comments'))
                ->leftJoin('comments', 'blogs.id', '=', 'comments.blog_id')
                ->whereraw('title LIKE ? OR description LIKE ?', ['%' . $request->get('search') . '%', '%' . $request->get('search') . '%'])
                ->groupBy('blogs.id')
                ->orderBy('user_comments', 'desc')
                ->paginate(self::getNumResults());
        } else {
            $blogs = ($category_id !== null ?
                Blog::whereraw('category_id = ? AND ( title LIKE ? OR description LIKE ? )', [$category_id, '%' . $request->get('search') . '%', '%' . $request->get('search') . '%']) :
                Blog::whereraw('title LIKE ? OR description LIKE ?', ['%' . $request->get('search') . '%', '%' . $request->get('search') . '%'])
                    ->orderby('updated_at', $orderBy)
                    ->paginate(self::getNumResults()));
        }

        return view('welcome')->with('blogs', $blogs);
    }

    public static function getNumResults()
    {
        switch (request()->{'num-results'}) {
            case 20:
            case 50:
            case 100:
                return request()->{'num-results'};
            default :
                return 10;
        }
    }

    public function order(Request $request, $category = null)
    {
        $category_id = null;
        $blogs = null;
        if ($category !== null) {
            if (Category::where('title', $category)->first() !== null) {
                $category_id = Category::where('title', $category)->first()->id;

                if ($request['order-by'] == 'Most Commented') {
                    $blogs = Blog::where('category_id', $category_id)
                        ->select('blogs.*', DB::raw('count(comments.blog_id) as user_comments'))
                        ->leftJoin('comments', 'blogs.id', '=', 'comments.blog_id')
                        ->groupBy('blogs.id')
                        ->orderBy('user_comments', 'desc')
                        ->paginate(self::getNumResults());
                } else if ($request['order-by'] == 'Old Posts') {
                    $blogs = Blog::where('category_id', $category_id)->orderBy('updated_at', 'asc')->paginate(self::getNumResults());
                } else {
                    $blogs = Blog::where('category_id', $category_id)->orderBy('updated_at', 'desc')->paginate(self::getNumResults());
                }
            }
        } else {
            if ($request['order-by'] == 'Most Commented') {
                $blogs = Blog::
                select('blogs.*', DB::raw('count(comments.blog_id) as user_comments'))
                    ->leftJoin('comments', 'blogs.id', '=', 'comments.blog_id')
                    ->groupBy('blogs.id')
                    ->orderBy('user_comments', 'desc')
                    ->paginate(self::getNumResults());
            } else if ($request['order-by'] == 'Old Posts') {
                $blogs = Blog::orderBy('updated_at', 'asc')->paginate(self::getNumResults());
            } else {
                $blogs = Blog::orderBy('updated_at', 'desc')->paginate(self::getNumResults());
            }
        }

        return view('welcome')->with([
            'blogs' => $blogs,
            'category_title' => $category,
        ]);
    }

    public function update(Request $request, $permalink)
    {
        $this->validate($request, [
            'category' => 'required',
            'title' => 'required|min:3|max:100',
            'description' => 'required|max:3365535|min:10',
        ]);

        $blog = Blog::where('permalink', urldecode($permalink))->first();
        $blog->title = $request->get('title');
        $blog->description = $request->get('description');
        $blog->category_id = $request->get('category');
        $dtime = \DateTime::createFromFormat("d.m.Y H:i", $request->get('date-input'));
        $blog->updated_at = $dtime->getTimestamp();
        $blog->update();

        return redirect()->back()->with('message', 'Successfully edited post!');
    }

    public function edit($permalink)
    {
        return view('admin.edit-post')->with('blog', Blog::where('permalink', urldecode($permalink))->first());
    }

    public function posts()
    {
        return view('admin.posts')->with('posts', Blog::all());
    }

    public function destroy($id)
    {
        $cat_id = Category::find(Blog::find($id)->category_id)->title;
        Blog::destroy($id);
        return redirect()->back()->with('message', 'Successfully deleted post!');
    }
}
