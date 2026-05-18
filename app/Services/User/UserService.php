<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserService
{
    /**
     * Get all users with pagination.
     */
    public function getAll()
    {
        return User::with('roles')->latest()->paginate(15);
    }

    /**
     * Find user by ID.
     */
    public function findById($id)
    {
        return User::with('roles')->findOrFail($id);
    }

    /**
     * Create a new user.
     */
    public function store($request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'status' => $request->status ?? 1,
        ]);

        // Assign role
        $user->syncRoles([$request->role]);

        return $user;
    }

    /**
     * Update an existing user.
     */
    public function update($request, $id)
    {
        $user = User::findOrFail($id);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => $request->status ?? 0,
        ];

        // Only update password if provided
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        // Re-assign role
        $user->syncRoles([$request->role]);

        return $user;
    }

    /**
     * Delete a user.
     */
    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
    }

    /**
     * Get all available roles.
     */
    public function getRoles()
    {
        return Role::orderBy('name')->get();
    }
}
