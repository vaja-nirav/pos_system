<?php

namespace App\Services\Role;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleService
{
    public function getAll()
    {
        return Role::with('permissions')->latest()->paginate(10);
    }

    public function getAllPermissions()
    {
        return Permission::all();
    }

    public function findById($id)
    {
        return Role::with('permissions')->findOrFail($id);
    }

    public function store($request)
    {
        $role = Role::create(['name' => $request->name]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return $role;
    }

    public function update($request, $id)
    {
        $role = Role::findOrFail($id);
        $role->update(['name' => $request->name]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        } else {
            $role->syncPermissions([]);
        }

        return $role;
    }

    public function delete($id)
    {
        $role = Role::findOrFail($id);

        // Prevent deleting admin role if you want
        if ($role->name === 'admin') {
            throw new \Exception('Admin role cannot be deleted.');
        }

        return $role->delete();
    }
}
