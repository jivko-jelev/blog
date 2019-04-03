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

    public function create()
    {
        return view('admin.categories');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:3|max:50|unique:categories',
        ]);

        $category = new Category();
        $category->title = $request->input('title');
        $category->parent_id = null;
        $category->created_at = Carbon::now();
        $category->save();

        return redirect()->back()->with('message', "Successfully added category with name \"$category->title\"");
    }

    public function show($title)
    {
        $cat = Category::where('title', $title)->first();
        if ($cat === null) {
            return redirect()->route('blogs.index')->withErrors('There is no such category');
        }
        return redirect()->route('blogs.order')->with(['request' => request(), 'title' => $title]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|min:3|max:50|unique:categories,title,' . $id
        ]);

        $category = Category::find($id);
        $old_category_name = $category->title;
        $category->title = $request->input('title');
        $category->parent_id = null;
        $category->updated_at = Carbon::now();
        $category->update();
        return redirect()->back()->with('message', "Successfully updated category name from \"$old_category_name\" to \"$category->title\"");
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        $category_name = $category->title;
        $category->delete();

        return redirect()->back()->with(['message' => "Successfully delete category \"$category_name\""]);
    }
}
