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

    public function store(Request $request)
    {
        $this->validate($request,[
            'category' => 'required',
            'title' => 'required|min:3|max:100',
            'description' => 'required|max:65535',
        ]);

        $category = new Blog;
        $category->category_id = $request->input('category');
        $category->title = $request->input('title');
        $category->description = $request->input('description');
        $category->user_id = Auth::id();
        $category->updated_at = null;
        $category->save();

        $categoryName = Category::find($category->category_id)->title;

        return redirect('category/' . strtolower($categoryName))->with('message',  'Succesfuly created post');
    }

    public function show($id)
    {
        $blog = Blog::find($id);
//        dd($blog->user_id);
//        dd(Category::where('id', $blog->category_id)->first()->title);
        return view('post')->with(['blog' => $blog, 'category_title' => Category::find($blog->category_id)->title]);
    }

    public function search(Request $request, $category = null)
    {
        $orderBy = $request->get('order-by') == null || $request->get('order-by') == 'New Posts' ? 'desc' : 'asc';
//        dd($orderBy);
        $category_id = $category !== null ? Category::where('title', $category)->first()->id : null;


        $blogs='';
        if($request->get('order-by')=='Most Commented'){
            $blogs=Blog::
                select('blogs.*', DB::raw('count(*) as user_comments'))
                ->leftJoin('comments', 'blogs.id', '=', 'comments.blog_id')
                ->whereraw('title LIKE ? OR description LIKE ?', ['%' . $request->get('search') . '%', '%' . $request->get('search') . '%'])
                ->groupBy('blogs.id')
                ->orderBy('user_comments', 'desc')
                ->get();
        }else {
            $blogs = ($category_id !== null ?
                Blog::whereraw('category_id = ? AND ( title LIKE ? OR description LIKE ? )', [$category_id, '%' . $request->get('search') . '%', '%' . $request->get('search') . '%']) :
                Blog::whereraw('title LIKE ? OR description LIKE ?', ['%' . $request->get('search') . '%', '%' . $request->get('search') . '%'])
                    ->orderby('created_at', $orderBy)
                    ->paginate(self::getNumResults()));
        }

//        dd($blogs);
        $blogs->withPath(Functions::withPath());
        return view('welcome')->with('blogs', $blogs);
    }

    public static function getNumResults(){
        switch (request()->{'num-results'}){
            case 20:
            case 50:
            case 100:return request()->{'num-results'};
            default : return 10;
        }
    }

    public function order(Request $request, $category = null)
    {
        $category_id = null;
        if($category !== null) {
            if(Category::where('title', $category)->first() !== null) {
                $category_id = Category::where('title', $category)->first()->id;
                if($request['order-by']=='Most Commented') {
                    $blogs=Blog::where('category_id', $category_id)
                        ->select('blogs.*', DB::raw('count(*) as user_comments'))
                        ->leftJoin('comments', 'blogs.id', '=', 'comments.blog_id')
                        ->groupBy('blogs.id')
                        ->orderBy('user_comments', 'desc')
                        ->get();
                }else if($request['order-by']=='Old Posts') {
                    $blogs = Blog::where('category_id', $category_id)->orderBy('created_at', 'asc')->paginate(self::getNumResults());
                }else{
                    $blogs = Blog::where('category_id', $category_id)->orderBy('created_at', 'desc')->paginate(self::getNumResults());
                }
            }
        }else {
            if($request['order-by']=='Most Commented') {
                $blogs=Blog::
                    select('blogs.*', DB::raw('count(*) as user_comments'))
                    ->leftJoin('comments', 'blogs.id', '=', 'comments.blog_id')
                    ->groupBy('blogs.id')
                    ->orderBy('user_comments', 'desc')
                    ->get();

            }else if($request['order-by']=='Old Posts') {
                $blogs = Blog::orderBy('created_at', 'asc')->paginate(self::getNumResults());
            }else{
                $blogs = Blog::orderBy('created_at', 'desc')->paginate(self::getNumResults());
            }
        }
        return view('welcome')->with(['blogs' => $blogs, 'category_title' => $category]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'category' => 'required',
            'title' => 'required|min:3|max:100',
            'description' => 'required|max:65535|min:10',
        ]);

        $blog=Blog::find($id);
        $blog->title = $request->get('title');
        $blog->description = $request->get('description');
        $blog->category_id = $request->get('category');
        $blog->update();

        return redirect()->route('blogs.show', $id)->with('message', 'Successfully edited post!');
    }

    public function edit($id)
    {
        return view('edit-post')->with('blog', Blog::find($id));
    }

    public function destroy($id)
    {
        $cat_id=Category::find(Blog::find($id)->category_id)->title;
        Blog::destroy($id);
        return redirect()->back()->with('message', 'Successfully deleted post!');
    }
}
