<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Store a user
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'nullable|string|regex:/^\+?6?0[0-9]{1,2}-*[0-9]{6,9}$/',
            'password' => 'required|string|min:6|max:255',
        ]);

        if ($validator->fails()) {
            return $this->respondCreateFailed();
        }

        try {
            // If this is a real project, for the phone number, I will remove the separating characters first
            // 012-22223333 becomes 01222223333
            // when needing to show, I will reformat the phone number to display back 012-22223333
            User::create($request->all());
            return Helper::respondSuccess();
        } catch (Exception $e) {
            return $this->respondCreateFailed();
        }
    }

    /**
     * Retrieve all users
     */
    public function all()
    {
        try {
            return User::all(['id', 'name', 'email', 'phone', 'password']);
        } catch (Exception $e) {
            return Helper::StandardResponse(1001, 'Failed to get data');
        }
    }

    /**
     * Update a user
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($request->id), // Exclude the current user's email
            ],
            'phone' => 'nullable|string|regex:/^\+?6?0[0-9]{1,2}-*[0-9]{6,9}$/',
        ]);

        if ($validator->fails()) {
            return $this->respondUpdateFailed();
        }

        $user = User::find($request->id);

        if (!$user) {
            return $this->respondUpdateFailed();
        }

        try {
            $user->update($request->only('name', 'email', 'phone'));
            $user->save();

            return Helper::respondSuccess();
        } catch (Exception $e) {
            return $this->respondUpdateFailed();
        }
    }

    private function respondCreateFailed()
    {
        return Helper::StandardResponse(1001, 'Create User Failed');
    }

    private function respondUpdateFailed()
    {
        return Helper::StandardResponse(1001, 'Update User Failed');
    }
}
