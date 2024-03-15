<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Method to create a new user
    public function create(Request $request)
    {
        // Validate request data
        $validatedData = $request->validate([
            'name' => 'required|string',
            'department' => 'required|string',
            'designation' => 'required|string',
            'phone_number' => 'required|string',
        ]);

        // Create the user
        $user = new User;
        $user->name = $request->name; 
        $user->fk_department = $request->department; 
        $user->fk_designation = $request->designation; 
        $user->phone_number = $request->phone_number; 

        $user->save();

        // Return a response (you can customize as needed)
        return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
    }

    // Method to search for users
    public function search(Request $request)
    {
    // Get the search query from the request
    $query = $request->input('searchText');

    // Perform search and eager load related models
    $users = User::with('fk_department', 'fk_designation')
            ->whereHas('fk_department', function ($q) use ($query) {
                $q->where('name', 'like', "%$query%");
            })
            ->orWhereHas('fk_designation', function ($q) use ($query) {
                $q->where('name', 'like', "%$query%");
            })
            ->orWhere('name', 'like', "%$query%")
            ->get();
    
     // Return JSON response with users data
     return response()->json($users);
    }

    public function getUsers()
    {
        // Fetch all users
        $users = User::with('fk_designation', 'fk_department')->get();

        // Return JSON response with users data
        return response()->json($users);
    }

}
