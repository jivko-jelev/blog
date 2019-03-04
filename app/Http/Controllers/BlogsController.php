<?php

namespace App\Http\Controllers;

use App\Category;
use App\Blog;
use Auth;
use DB;
use App\Functions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Session\Session;


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
        $count = 0;
        while ((self::isRepeatingPermalink($categories, $title . '-' . ++$count))) {
        }
        return $title . '-' . $count;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'category' => 'required',
            'title' => 'required|min:3|max:100',
            'description' => 'required|max:65535',
        ]);

        $blog = new Blog;
        $blog->category_id = $request->input('category');
        $blog->title = $request->input('title');
        $blog->description = $request->input('description');
        $blog->permalink = mb_strtolower(self::getUniquePermalink($request['title']));
        $blog->user_id = Auth::id();
        $blog->updated_at = null;
        $blog->save();

        $categoryName = Category::find($blog->category_id)->title;

        return redirect('category/' . strtolower($categoryName))->with('message', 'Succesfuly created post');
    }

    public function show($id)
    {
        $blog = Blog::where('permalink', $id)->first();
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
                    ->orderby('created_at', $orderBy)
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
                    $blogs = Blog::where('category_id', $category_id)->orderBy('created_at', 'asc')->paginate(self::getNumResults());
                } else {
                    $blogs = Blog::where('category_id', $category_id)->orderBy('created_at', 'desc')->paginate(self::getNumResults());
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
                $blogs = Blog::orderBy('created_at', 'asc')->paginate(self::getNumResults());
            } else {
                $blogs = Blog::orderBy('created_at', 'desc')->paginate(self::getNumResults());
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
            'description' => 'required|max:65535|min:10',
        ]);

        $blog = Blog::where('permalink', $permalink)->first();
        $blog->title = $request->get('title');
        $blog->description = $request->get('description');
        $blog->category_id = $request->get('category');
        $blog->update();

        return redirect()->route('blogs.show', $permalink)->with('message', 'Successfully edited post!');
    }

    public function edit($permalink)
    {
        return view('edit-post')->with('blog', Blog::where('permalink', $permalink)->first());
    }

    public function destroy($id)
    {
        $cat_id = Category::find(Blog::find($id)->category_id)->title;
        Blog::destroy($id);
        return redirect()->back()->with('message', 'Successfully deleted post!');
    }
}
