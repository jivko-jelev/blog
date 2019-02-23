<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use Carbon\Carbon;
use Auth;

class CommentsController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'message' => 'required|max:4096',
        ]);

//        dd(Carbon::now()->toDateTimeString());
        $comment = new Comment;
        $comment->message = $request->get('message');
        $comment->user_id = Auth::id();
        $comment->blog_id = $request->get('blog_id');
        $comment->created_at = Carbon::now();
        $comment->save();

        return redirect()->back()->with('message',  'Succesfuly added comment');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {
        Comment::destroy($id);
        //$comment = Comment::find($id);
        //$comment->delete();

        return redirect()->back()->with(['message' =>  'Succesfuly delete comment']);
    }
}
