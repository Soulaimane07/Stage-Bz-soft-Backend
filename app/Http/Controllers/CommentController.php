<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::all();
        return $comments;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $comment = new Comment;

        $comment->complaint = $request->input('complaint');
        $comment->writer = $request->input('writer');
        $comment->text = $request->input('text');
        $comment->date = $request->input('date');

        $comment->save();

        return $comment;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $comment = Comment::find($id);
        return $comment;
    }
    
    public function getComments(string $id)
    {
        $comments = Comment::where('complaint', $id)->get();
        return $comments;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Comment::find($id)->delete();
        return "Comment is deleted";
    }
}
