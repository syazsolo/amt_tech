<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
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

    private function respondCreateFailed()
    {
        return Helper::StandardResponse(1001, 'Create User Failed');
    }
}
