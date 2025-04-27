<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $users = User::whereNull('deleted_at')->with([
            'gender:id,gender',
            'state:id,name',
            'city:id,name'
        ])->select('id', 'first_name', 'last_name', 'email', 'contact_number', 'postcode', 'gender_id', 'state_id', 'city_id')
        ->get();
        
        // dd($users);
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id){
        $user = User::with(['gender', 'state', 'city'])->find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id){
        $user = User::findOrFail($id);

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email,' . $id,
            'contact_number' => 'nullable|string|max:10',
            'postcode'   => 'nullable|string|max:10',
            'gender_id' => 'required'
        ]);

        $user->first_name = $request->first_name;
        $user->last_name  = $request->last_name;
        $user->email      = $request->email;
        $user->contact_number = $request->contact_number;
        $user->postcode   = $request->postcode;
        $user->gender_id   = $request->gender_id;
        
        $user->save();

        return response()->json([
            'message' => 'User updated successfully.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id){
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $user->delete();
        return response()->json(['message' => 'User deleted successfully'], 200);
    }

}
