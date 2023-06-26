<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;


class UserController extends Controller
{ 

    /**
     * Fetch all users with the latest ones first.
     * Paginate the results into chunks of 25 users.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection Collection of User resources.
     */
    public function index() 
    {
        $users = User::latest()->paginate(25);
        return UserResource::collection($users);
    } 



    /**
     * Create a new user in the database after validating incoming request data.
     *
     * @param Request $request Incoming request instance.
     * 
     * @return \Illuminate\Http\Resources\Json\JsonResource Single User resource.
     * 
     * @throws \Illuminate\Validation\ValidationException If validation fails.
     */
    public function store(Request $request) 
    { 
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/'],
            'phone_number' => ['required', 'regex:/^0[67][0-9]{8}$/','unique:users'],
            'role_id' => ['required', 'integer', 'exists:roles,id'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'role_id' => $request->role_id,
        ]);

        return new UserResource($user);
    }


    /**
     * Fetch a single user by its primary key.
     *
     * @param User $user The user instance being accessed.
     * 
     * @return \Illuminate\Http\Resources\Json\JsonResource Single User resource.
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }
    
    
    
    /**
     * Update an existing user's data in the database after validating incoming request data.
     *
     * @param Request $request Incoming request instance.
     * @param User $user The user instance being updated.
     * 
     * @return \Illuminate\Http\Resources\Json\JsonResource Single updated User resource.
     * 
     * @throws \Illuminate\Validation\ValidationException If validation fails.
     */

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'sometimes|string',
            'email' => 'sometimes|email|unique:users,email,'.$user->id,
            'phone_number' => 'sometimes|unique:users,phone_number,'.$user->id,
            'role_id' => 'sometimes|exists:roles,id',
            'password' => ['sometimes', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/'],
        ]);
     
        $user->fill($request->all());
    
        if($request->has('password')) {
            $user->password = Hash::make($request->password);
        }
    
        $user->save();
    
        return new UserResource($user);
    }
    

}
