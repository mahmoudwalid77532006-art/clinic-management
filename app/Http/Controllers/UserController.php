<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(StoreUserRequest $request)
    {
        User::create($request->validated());

        return redirect()->route('user.index')->with('success', 'تم إنشاء المستخدم.');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(StoreUserRequest $request, User $user)
    {
        $data = $request->validated();

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('user.index')->with('success', 'تم تحديث المستخدم.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('user.index')->with('success', 'تم حذف المستخدم.');
    }
}
