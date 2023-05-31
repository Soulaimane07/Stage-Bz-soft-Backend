<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\Comment;
use App\Models\User;

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
        $complaint->complainer = $request->input('complainer');
        
        $images = $request->file('images');
        $imagess = array();
        
        if($images){
            foreach ($images as $key=>$image) {
                $name = $image->getClientOriginalName();
                $image->storeAs('public/images/complaints', $name);
                array_push($imagess, $name);
            }
            $complaint->image = $imagess;
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
    
    public function getComplaints(string $email)
    {
        $user = User::where('email', $email)->get();
        $hello =  json_decode(str_replace('""', '', $user[0]->complaints));
        $comps = Complaint::whereIn('id', $hello)->get();

        $complaints = Complaint::where('complainer', $email)->get();

        $result = array_merge(json_decode($comps), json_decode($complaints));

        return $result;
    }


    
    public function affect(Request $request, string $complaint)
    {
        $hello = User::whereIn("id", $request->list)->get();
        
        foreach ($hello as $key => $user) {
            $array = json_decode($user->complaints);
            
            if($user->complaints === null){
                $new = array($request->complaint);
                $result = User::whereIn("id", $request->list)->update(['complaints'=> $new]);
            } 
            else {
                array(array_push($array, $request->complaint));
                $result = User::whereIn("id", $request->list)->update(['complaints'=> $array]);
            }
        }
       
        return $result;
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
        Comment::where('complaint', $id)->delete();
        return "User is deleted";
    }
}
