<?php

namespace App\Http\Controllers\Web\Role;

use App\Http\Controllers\Controller;
use App\Services\Role\RoleService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller implements HasMiddleware
{
    protected $roleService;

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_roles', only: ['index']),
            new Middleware('permission:create_roles', only: ['create', 'store']),
            new Middleware('permission:update_roles', only: ['edit', 'update']),
            new Middleware('permission:delete_roles', only: ['destroy']),
        ];
    }

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index()
    {
        $roles = $this->roleService->getAll();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = $this->roleService->getAllPermissions();
        
        // Group permissions by module for the view
        $groupedPermissions = [];
        foreach ($permissions as $permission) {
            $parts = explode('_', $permission->name, 2);
            $action = $parts[0];
            $module = $parts[1] ?? 'other';
            $groupedPermissions[$module][$action] = $permission;
        }

        return view('roles.create', compact('groupedPermissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'nullable|array',
        ]);

        $this->roleService->store($request);

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function edit($id)
    {
        $role = $this->roleService->findById($id);
        $permissions = $this->roleService->getAllPermissions();
        
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        $groupedPermissions = [];
        foreach ($permissions as $permission) {
            $parts = explode('_', $permission->name, 2);
            $action = $parts[0];
            $module = $parts[1] ?? 'other';
            $groupedPermissions[$module][$action] = $permission;
        }

        return view('roles.edit', compact('role', 'groupedPermissions', 'rolePermissions'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $id,
            'permissions' => 'nullable|array',
        ]);

        $this->roleService->update($request, $id);

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy($id)
    {
        try {
            $this->roleService->delete($id);
            return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('roles.index')->with('error', $e->getMessage());
        }
    }
}
