<?php

use App\Models\Department;
use App\Models\Designation;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // Fetch departments and designations data
    $departments = Department::all();
    $designations = Designation::all();

    // Pass data to the view
    return view('welcome', compact('departments', 'designations'));
});

// Route for creating a user
Route::post('/users/create', [UserController::class, 'create']);

// Route for searching users
Route::get('/users/search', [UserController::class, 'search']);

// Route for fetching user data
Route::get('/users', [UserController::class, 'getUsers']);
