<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            if ($validator->fails()) {
                return ResponseFormatter::error($validator->errors(), 'Validation Failed', 422);
            }

            $credentials = $request->only('email', 'password');

            if (!Auth::attempt($credentials)) {
                return ResponseFormatter::error(['message' => 'Invalid credentials'], 'Authentication Failed', 401);
            }

            $user = Auth::user();

            $tokenResult = $user->createToken('authToken')->plainTextToken;

            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ], 'Authenticated');
        } catch (\Exception $error) {
            Log::error('Login error: ' . $error->getMessage());
            return ResponseFormatter::error(['message' => 'An unexpected error occurred'], 'Authentication Failed', 500);
        }
    }

    public function registerRelawan(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255', 'regex:/^[\pL\s\-]+$/u'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'no_hp' => ['required', 'string', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'max:25'],
                'jns_kelamin' => ['required', 'string', 'max:255'],
                'alamat' => ['required', 'string', 'max:2000', 'regex:/^[a-zA-Z0-9\s\-\,\.]+$/'],
                'tmp_pengabdian' => ['required', 'string', 'max:255'],
                'gln_darah' => ['required', 'string', 'max:255'],
                'password' => [
                    'required',
                    Password::min(8)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
                ],
            ], [
                'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, angka, dan simbol.',
            ]);

            if ($validator->fails()) {
                return ResponseFormatter::error($validator->errors(), 'Validation Failed', 422);
            }

            $user = User::create([
                'name' => strip_tags($request->name),
                'email' => $request->email,
                'no_hp' => $request->no_hp,
                'jns_kelamin' => $request->jns_kelamin,
                'alamat' => strip_tags($request->alamat),
                'tmp_pengabdian' => $request->tmp_pengabdian,
                'gln_darah' => $request->gln_darah,
                'role' => 'relawan',
                'level' => 1,
                'password' => Hash::make($request->password),
            ]);

            $userResponse = $user;

            return ResponseFormatter::success([
                'user' => $userResponse
            ], 'User Registered Successfully. Please log into the application.');
        } catch (\Exception $error) {
            Log::error('Registration error: ' . $error->getMessage());
            return ResponseFormatter::error(['error' => 'An unexpected error occurred'], 'Registration Failed', 500);
        }
    }

    public function registerPasien(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255', 'regex:/^[\pL\s\-]+$/u'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'no_hp' => ['required', 'string', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'max:25'],
                'jns_kelamin' => ['required', 'string', 'max:255'],
                'alamat' => ['required', 'string', 'max:2000', 'regex:/^[a-zA-Z0-9\s\-\,\.]+$/'],
                'gln_darah' => ['required', 'string', 'max:255'],
                'password' => [
                    'required',
                    Password::min(8)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
                ],
            ], [
                'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, angka, dan simbol.',
            ]);

            if ($validator->fails()) {
                return ResponseFormatter::error($validator->errors(), 'Validation Failed', 422);
            }

            $user = User::create([
                'name' => strip_tags($request->name),
                'email' => $request->email,
                'no_hp' => $request->no_hp,
                'jns_kelamin' => $request->jns_kelamin,
                'alamat' => strip_tags($request->alamat),
                'gln_darah' => $request->gln_darah,
                'role' => 'relawan',
                'level' => 1,
                'password' => Hash::make($request->password),
            ]);

            $userResponse = $user;

            return ResponseFormatter::success([
                'user' => $userResponse
            ], 'User Registered Successfully. Please log into the application.');
        } catch (\Exception $error) {
            Log::error('Registration error: ' . $error->getMessage());
            return ResponseFormatter::error(['error' => 'An unexpected error occurred'], 'Registration Failed', 500);
        }
    }

    public function fetch(Request $request)
    {
        try {
            $user = $request->user();

            if (!$user) {
                return ResponseFormatter::error(null, 'User not authenticated', 401);
            }

            $userResponse = $user;

            return ResponseFormatter::success($userResponse, 'User profile data retrieved successfully');
        } catch (\Exception $error) {
            Log::error('Fetch profile error: ' . $error->getMessage());
            return ResponseFormatter::error(['message' => 'An unexpected error occurred'], 'Failed to retrieve user profile', 500);
        }
    }

    public function updateProfile(Request $request)
    {
        try {
            $user = Auth::user();

            $validator = Validator::make($request->all(), [
                'name' => ['sometimes', 'required', 'string', 'max:255'],
                'email' => ['sometimes', 'required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
                'password' => ['nullable', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', 'confirmed'],
                'no_hp' => ['nullable', 'string', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'max:20'],
            ], [
                'password.regex' => 'Password harus mengandung setidaknya satu huruf kecil, satu huruf besar, dan satu angka.',
            ]);

            if ($validator->fails()) {
                return ResponseFormatter::error($validator->errors(), 'Validation Failed', 422);
            }

            $data = $request->only(['name', 'email', 'no_hp']);

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);

            $userResponse = $user;

            return ResponseFormatter::success($userResponse, 'Profile Updated Successfully');
        } catch (\Exception $error) {
            Log::error('Update profile error: ' . $error->getMessage());
            return ResponseFormatter::error(['message' => 'An unexpected error occurred'], 'Failed to update profile', 500);
        }
    }

    public function updatePhoto(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($validator->fails()) {
                return ResponseFormatter::error($validator->errors(), 'Validation Failed', 422);
            }

            $user = Auth::user();

            if ($request->hasFile('file')) {
                $path = $request->file('file')->store('assets/user', 'public');

                if (!$path) {
                    throw new \Exception('Failed to store photo');
                }

                $user->profile_photo_path = $path;
                $user->save();

                return ResponseFormatter::success(['photo' => $path], 'Photo successfully updated');
            } else {
                return ResponseFormatter::error(null, 'No file received', 400);
            }
        } catch (\Exception $error) {
            Log::error('Update photo error: ' . $error->getMessage());
            return ResponseFormatter::error(['message' => 'An unexpected error occurred'], 'Failed to update photo', 500);
        }
    }
}
