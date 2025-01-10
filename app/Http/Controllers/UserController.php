<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Http\Requests\UserRequest;
use App\Http\Filters\UserFilter;

class UserController extends Controller
{
    public function index(UserFilter $request)
    {
        $currentUser = auth()->user();
        if (!isset($currentUser) || $currentUser["role"] !== "admin") {
            return response(['message' => 'You have no permission to get all users'], 403);
        };

        $users = User::withTrashed()->filter($request)->get();
        return response(["message" => "ok", "data" => $users], 200);
    }

    public function create(UserRequest $request)
    {
        $data = $request->all();
        $data['password'] = Hash::make($data['password']);

        try {
            $user = new User();
            $user->fill($data)->save();
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()], 500);
        }
        return response(['message' => 'ok'], 200);
    }


    public function update(UserRequest $request, $id)
    {
        $user = User::withTrashed()->find($id);
        $currentUser = auth()->user();
        $data = $request->all();

        $values = ['password', 'name', 'last_name', 'second_name'];
        $filtredData = [];

        if ($user === null) {
            return response(['message' => 'User not found'], 404);
        }

        foreach ($values as $value) {
            if (isset($data[$value])) {
                $filtredData[$value] = $value === 'password' ? Hash::make($data[$value]) : $data[$value];
            };
        }


        if ($currentUser['role'] === 'admin') {
            if (isset($data['role'])) {
                $filtredData['role'] = $data['role'];
            };
            $user->fill($filtredData)->save();
        } elseif ($currentUser['id'] === $user['id']) {
            if (isset($data['role'])) {
                return response(['message' => 'You have no permission to change role'], 403);
            };

            $user->fill($filtredData)->save();
        } else {
            return response(['message' => 'You have no permission to change role'], 403);
        }

        return response(['message' => 'ok'], 200);
    }

    public function destroy(UserRequest $request, $id)
    {

        $user = User::find($id);
        $currentUser = auth()->user();

        if ($user === null) {
            return response(['message' => 'User not found'], 404);
        }

        if ($currentUser['role'] === 'admin') {
            if ($user['role'] === 'admin') {
                if (count(User::where('role', 'admin')->where('active', 'Y')->get()) <= 1) {
                    return response(['message' => 'You have to leave at least one admin'], 403);
                };
            }
            $user['active'] = 'N';
            $user->save();
            $user->delete();
            return response(['message' => 'ok'], 200);
        } elseif ($currentUser['id'] === $user['id']) {
            $user['active'] = 'N';
            $user->save();
            $user->delete();
            return response(['message' => 'ok', 'data' => $user->toArray()], 200);
        }

        return response(['message' => 'You have no permission to delete this user'], 403);
    }
}
