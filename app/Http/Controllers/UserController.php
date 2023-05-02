<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return $users;
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
            'cname' => ['string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:50', 'unique:users'],
            'fname' => ['string', 'max:50'],
            'cname' => ['string', 'max:50'],
            'phone' => ['int', 'max:10'],
            'type' => ['string', 'max:10'],
            'pass' => ['required', 'string', 'min:6'],
        ]);

        $user = User::create([
            'cname' => $request['cname'],
            'email' => $request['email'],
            'fname' => $request['fname'],
            'lname' => $request['lname'],
            'phone' => $request['phone'],
            'type' => $request['type'],
            'pass' => Hash::make($request['pass']),
        ]);

        return $user;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        $user = User::find($id);
        $user->cname = $request->cname;
        $user->email = $request->email;
        $user->fname = $request->fname;
        $user->lname = $request->lname;
        $user->phone = $request->phone;

        if(Hash::needsRehash($request->pass)){
            $user->pass = Hash::make($request->pass);
        }else {
            $user->pass = $request->pass;
        }

        $result= $user->save();
        return $user;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::find($id)->delete();
        return "User is deleted";
    }
}
