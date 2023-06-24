<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Advertiser;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    /**
     * User register
     *
     * 
     * @bodyParam name string required The name of the user. Example: John Doe
     * @bodyParam email string required The email of the user. Must be a valid email address. Example: john@example.com
     * @bodyParam phone_number string required The phone number of the user. Must follow the pattern '^0[67][0-9]{8}$'. Example: 0612345678
     * @bodyParam password string required The password of the user. Must be at least 8 characters. Example: securepassword
     * @bodyParam firm string required The firm of the user. Example: My Firm
     * @bodyParam domain string required The domain of the user. Example: mydomain.com
     */
    public function register(Request $request)
    {
        $customMessages = [
            'required' => 'The :attribute field is required.',
            'unique' => 'The :attribute has already been taken.',
            'min' => [
                'string'  => 'The :attribute must be at least :min characters.',
            ],
            'max' => [
                'string'  => 'The :attribute may not be greater than :max characters.',
            ],
            'email' => 'The :attribute must be a valid email address.',
            'regex' => 'The :attribute format is invalid.',
            'in' => 'The selected :attribute is invalid.',
            'password.regex' => 'The :attribute must be at least 8 characters and include at least one uppercase letter, one lowercase letter, one number, and one special character.',

        ];
    
        $domains = implode(',', Advertiser::getDomainEnumValues());
    
        try { 
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'phone_number' => ['required','string','unique:users', 'regex:/^0[67][0-9]{8}$/'],
                'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/'],
                'firm' => 'required|string|max:255',
                'domain' => 'required|string|in:' . $domains,
            ], $customMessages);
    
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email, 
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password),
                'role_id' => 4,
            ]);
    
            $advertiser = Advertiser::create([
                'user_id' => $user->id,
                'firm' => $request->firm,
                'domain' => $request->domain,
            ]);
    
            return response()->json([
                'message' => 'Registration successful.',
                'user' => $user,
                'advertiser' => $advertiser,
                'token' => $user->createToken('appToken')->plainTextToken,
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Registration failed.',
                'errors' => $e->getMessage()
            ], 400);
        }
    }
    
    
    
    
    /**
     * User login
     *
     * @bodyParam phone_number string required The phone number of the user. Must follow the pattern '^0[67][0-9]{8}$'. Example: 0612345678
     * @bodyParam password string required The password of the user. Must be at least 8 characters. Example: securepassword
     */
    public function login(Request $request)
    {
        try {
            $request->validate([
                'phone_number' => ['required','string','regex:/^0[67][0-9]{8}$/'],
                'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/'],
    
            ]);

            $user = User::where('phone_number', $request->phone_number)->first();

            if (!$user) {
                return response()->json([
                    'message' => 'The provided phone number does not belong to any user.',
                ], 404);
            }

            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'message' => 'The provided password is incorrect.',
                ], 403);
            }

            return response()->json([
                'message' => 'Login successful.',
                'user' => $user,
                'advertiser' => $user->advertiser,
                'token' => $user->createToken('appToken')->plainTextToken,
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Login failed.',
                'errors' => $e->getMessage()
            ], 400);
        }
    }

     
      /**
     * User logout
     *
     * @authenticated
     * 
     */
    public function logout(Request $request)
    {
        // Revoke the user's current token...
        $request->user()->currentAccessToken()->delete();
    
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }
    
}
