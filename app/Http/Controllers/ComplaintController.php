<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $complaints = Complaint::all();
        return $complaints;
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
        $request->validate([
            // 'title' => ['required', 'string'],
            // 'property' => ['required', 'string'],
            // 'desc' => ['required', 'string'],
        ]);

        $complaint = new Complaint;

        $complaint->title = $request->input('title');
        $complaint->property = $request->input('property');
        $complaint->desc = $request->input('desc');
        $complaint->date = $request->input('date');

        if($request->file('image')){
            $name = $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/images/complaints', $name);
            $complaint->image = $name;
        }

        $complaint->save();

        return $complaint;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $complaint = Complaint::find($id);
        return $complaint;
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
        Complaint::find($id)->delete();
        return "User is deleted";
    }
}
