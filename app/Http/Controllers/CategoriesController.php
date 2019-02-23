<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Blog;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{

    public function index()
    {
        return view('categorylist')->with('categories', Category::get());
    }

    public function create()
    {
        return view('category');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
                'title' => 'required|min:3|max:50|unique:categories',
        ]);

        $category = new Category();
        $category->title = $request->input('title');
        $category->parent_id = null;
        $category->created_at = Carbon::now();
        $category->save();

        return redirect()->back()->with('message',  'Succesfuly added category');
    }

    public function show($title)
    {
        $cat=Category::where('title', $title)->first();
        if($cat === null){
            return redirect()->route('blogs.index')->withErrors('There is no such category');
        }
        return redirect()->route('blogs.order')->with(['request'=>request(), 'title'=> $title]);
        //return view('welcome')->with(['blogs' => Blog::where('category_id', $cat->id)->orderby('id', 'desc')->paginate(15), 'title' => ucfirst($title)]);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
                    'title' => 'required|min:3|max:50|unique:categories,title,' . $id
            ]);

        $category = Category::find($id);
        $category->title = $request->input('title');
        $category->parent_id = null;
        $category->updated_at = Carbon::now();
        $category->update();
        return redirect()->back()->with('message',  'Succesfuly updated category');
    }

    public function destroy($id)
    {
        $comment = Category::find($id);
        $comment->delete();

        return redirect()->back()->with(['message' =>  'Succesfuly delete category']);
    }
}
