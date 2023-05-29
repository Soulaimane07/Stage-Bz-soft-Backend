<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Priority;

class PriorityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $priorities = Priority::all();
        return $priorities;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required','string'],
            'color' => ['required','string'],
        ]);

        $priority = Priority::create([
            'title' => $request['title'],
            'color' => $request['color']
        ]);

        return $priority;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $priority = Priority::find($id);
        return $priority;
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
        $priority = Priority::find($id);
        $priority->title = $request->title;
        $priority->color = $request->color;

        $result = $priority->save();
        return $priority;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Priority::find($id)->delete();
        return "Priority is deleted";
    }
}
