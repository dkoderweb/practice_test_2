<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Models\Country;
use DataTables;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $data = User::with(['country', 'state', 'city'])->select('*')->where('type','0')->whereNull('deleted_at');

        return Datatables::of($data)
        ->addColumn('country_name', function ($user) {
            return $user->country ? $user->country->name : '';
        })
        ->addColumn('state_name', function ($user) {
            return $user->state ? $user->state->name : '';
        })
        ->addColumn('city_name', function ($user) {
            return $user->city ? $user->city->name : '';
        })
       ->addColumn('action', function ($user) {
            return '<a href="'.route('users.edit', $user->id).'" class="btn btn-sm btn-warning">Edit</a>' .
                '<button class="button delete-confirm btn btn-sm btn-danger" data-url="'.url("/admin/users/delete/{$user->id}").'"><i class="fa fa-trash"></i></button>';
        })

        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Country::get(["name", "id"]);
        return view('admin.dashboard.create',compact("countries"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {    
          $validatedData = $request->validated();
          $user = User::store($validatedData);
        return redirect()->route('admin.home')->with('users','User created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
         $user = User::findOrFail($id);
        $countries = Country::get(["name", "id"]);

        return view('admin.dashboard.create',compact("user",'countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
         $validatedData = $request->validated();
             $user = User::findOrFail($id);
            $user->updateUserData($validatedData);
    return redirect()->route('admin.home')->with('users', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
         $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.home')->with('delete_user', 'User deleted successfully');
    }
}
