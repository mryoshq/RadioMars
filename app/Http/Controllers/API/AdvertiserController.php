<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Advertiser;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\AdvertiserResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; 


class AdvertiserController extends Controller 
{
     
    /**
     * Store a newly created advertiser
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|App\Http\Resources\AdvertiserResource
     * 
     * @throws \Illuminate\Validation\ValidationException If the validation fails
     * @throws \Exception If an unexpected error occurs
     * 
     * @authenticated
     * @bodyParam domain string The domain of the advertiser.
     * @bodyParam firm string The firm of the advertiser.
     * @bodyParam name string required The name of the user.
     * @bodyParam email string required The email of the user.
     * @bodyParam password string required The password of the user.
     * @bodyParam phone_number string required The phone number of the user.
     */
    public function store(Request $request)
    {
        $domains = implode(',', Advertiser::getDomainEnumValues());
        $messages = [
            'domain.in' => 'The selected domain is invalid. Please choose a valid domain.',
            'firm.required' => 'The firm field is required.',
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.max' => 'The email may not be greater than 255 characters.',
            'email.unique' => 'The email has already been taken.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
            'phone_number.required' => 'The phone number field is required.',
            'phone_number.regex' => 'The phone number format is invalid.',
            'phone_number.unique' => 'The phone number has already been taken.',
        ];
    
        try {
            $data = $request->validate([
                'domain' => 'sometimes|in:' . $domains,
                'firm' => 'required',
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/'],
                'phone_number' => ['required', 'regex:/^0[67][0-9]{8}$/','unique:users'],
            ], $messages);
    
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'phone_number' => $data['phone_number'],
                'role_id' => 4,
            ]);
    
            $advertiser = Advertiser::create([
                'domain' => $data['domain'],
                'firm' => $data['firm'],
                'user_id' => $user->id,
            ]);
    
            return new AdvertiserResource($advertiser);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // handle validation exception
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unexpected error occurred. Please try again.'], 500);
        }
    }
    


        /**
     * Display the specified advertiser.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|App\Http\Resources\AdvertiserResource
     * 
     * @throws \Exception If an unexpected error occurs
     *
     * @authenticated
     */
    public function show(Request $request)
    {
        try {
            $advertiser = $request->user()->advertiser;
            if (!$advertiser) {
                return response()->json(['error' => 'Advertiser not found'], 404);
            }
    
            $advertiser->load('user');  // load the user data
            $advertiser->load('ads');
            $advertiser->load('payments');
    
            return new AdvertiserResource($advertiser);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unexpected error occurred. Please try again.'], 500);
        }
    }
    
  





    /**
     * Update the specified advertiser in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|App\Http\Resources\AdvertiserResource
     * 
     * @throws \Illuminate\Validation\ValidationException If the validation fails
     * @throws \Exception If an unexpected error occurs
     *
     * @authenticated
     * @bodyParam domain string The domain of the advertiser.
     * @bodyParam firm string The firm of the advertiser.
     * @bodyParam name string The name of the user.
     * @bodyParam email string The email of the user.
     * @bodyParam phone_number string The phone number of the user.
     * @bodyParam password string The password of the user.
     */
    public function update(Request $request)
    {
        $domains = implode(',', Advertiser::getDomainEnumValues());
        $messages = [
            'domain.in' => 'The selected domain is invalid. Please choose a valid domain.',
            'firm.string' => 'The firm name must be a string.',
            'firm.max' => 'The firm name may not be greater than 40 characters.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'email.email' => 'The email must be a valid email address.',
            'phone_number.regex' => 'The phone number format is invalid.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
        ];

        try {
            $data = $request->validate([
                'domain' => 'sometimes|in:' . $domains,
                'firm' => 'sometimes|string|max:40',
                'name' => ['sometimes', 'string', 'max:255'],
                'email' => ['sometimes', 'string', 'email', 'max:255'],
                'phone_number' => ['sometimes', 'regex:/^0[67][0-9]{8}$/'],
                'password' => ['sometimes', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/'],
            ], $messages);

            $advertiser = $request->user()->advertiser;
            if (!$advertiser) {
                return response()->json(['error' => 'Advertiser not found'], 404);
            }

            DB::beginTransaction();

            $advertiser->fill([
                'domain' => $data['domain'] ?? $advertiser->domain,
                'firm' => $data['firm'] ?? $advertiser->firm,
            ]);

            // Update the user related fields directly from the $data array
            $advertiser->user->fill([
                'name' => $data['name'] ?? $advertiser->user->name,
                'email' => $data['email'] ?? $advertiser->user->email,
                'phone_number' => $data['phone_number'] ?? $advertiser->user->phone_number,
            ]);

            if (isset($data['password'])) {
                $advertiser->user->password = Hash::make($data['password']);
            }

            $advertiser->push();

            DB::commit();

            $advertiser->load('user');

            return new AdvertiserResource($advertiser);
    
    
    } catch (\Illuminate\Validation\ValidationException $e) {
            // handle validation exception
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage());

            return response()->json(['error' => 'Unexpected error occurred. Please try again.'], 500);
        }
    }

    
    
}
 