<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Api_Models\Admin;
use App\Traits\GeneralTraits;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    use GeneralTraits;


    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|string|exists:admins:email',
    //         'password' => 'required|string',
    //     ]);
    //     $credentials = $request->only('email', 'password');

    //     $token = Auth::attempt($credentials);
    //     if (!$token) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Unauthorized',
    //         ], 401);
    //     }

    //     $user = Auth::user();
    //     return response()->json([
    //             'status' => 'success',
    //             'user' => $user,
    //             'authorisation' => [
    //                 'token' => $token,
    //                 'type' => 'bearer',
    //             ]
    //         ]);

    // }

    // public function login(Request $request)
    // {
    //     if ($request->isMethod('post')) {

    //         $data = $request->all();

    //         try {

    //             $rules = [
    //                 "email" => "required",
    //                 "password" => "required"

    //             ];
    //             $customMessage = [
    //                 'email.required' => 'Email is required!',
    //                 'email.email' => 'Valid Email is required',
    //                 'password.required' => 'Password is required!',
    //             ];

    //             // $validator = Validator::make($request->all(), $rules);
    //             $this->validate($request, $rules, $customMessage);

    //             if (Auth::guard('admin-api')->attempt(['email' => $data['email'], 'password' => $data['password']])) {
    //                 echo "<pre>";
    //                 print_r($data);
    //                 die;
    //                 return Auth::guard('admin-api')->user();
    //             } else {
    //                 return $this->returnError('', 'Invalid Email or Password ');
    //             }

    //             // if ($validator->fails()) {
    //             //     $code = $this->returnCodeAccordingToInput($validator);
    //             //     return $this->returnValidationError($code, $validator);
    //             // }

    //             //login

    //             // $credentials = $request->only(['email', 'password']);



    //             // $token = Auth::guard('admin-api')->attempt($credentials);

    //             // if (!$token) {
    //             //     return $this->returnError('E001', ' Email or Password not correct  ');
    //             // }


    //             // $admin = Auth::guard('admin-api')->user();
    //             // $admin->api_token = $token;
    //             // //return token
    //             // return $this->returnData('admin', $admin);

    //         } catch (\Exception $ex) {
    //             return $this->returnError($ex->getCode(), $ex->getMessage());
    //         }
    //     }
    // }

    public function getAllAdmins()
    {
        $admins = Admin::get();
        return $this->returnData('admins', $admins, 'success');
    }

    public function login(Request $request)
    {
        try {
            $rules = [
                "email" => "required",
                "password" => "required"
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            //login
            $credentials = $request->only(['email', 'password']);
            $token = Auth::guard('admin-api')->attempt($credentials);
            if (!$token) {
                return $this->returnError('E001', 'Invalid email or password');
            }
            $admin = Auth::guard('admin-api')->user();
            $admin->api_token = $token;
            // //return token
            return $this->returnData('admin', $admin);

        } catch (\Exception $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function logout(Request $request)
    {
        $token = $request->header('auth-token');
        if ($token) {
            try {
                JWTAuth::setToken($token)->invalidate();
                return $this->returnSuccessMessage('logged out successfully', '');
            } catch (\Exception $ex) {
                return $this->returnError($ex->getCode(), $ex->getMessage());
            }
        } else {
            return $this->returnError('', 'Some thing wrong');
        }
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
        $user = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $token = Auth::guard('admin-api')->login($user);
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function userLogin(Request $request)
    {
        try {
            $rules = [
                "email" => "required",
                "password" => "required"
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            //login
            $credentials = $request->only(['email', 'password']);
            $token = Auth::guard('user-api')->attempt($credentials);
            if (!$token) {

                return $this->returnError('E001', 'Invalid email or password');
            }
            $user = Auth::guard('user-api')->user();

            $user->api_token = $token;
            // //return token
            return $this->returnData('user', $user);

        } catch (\Exception $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }
}