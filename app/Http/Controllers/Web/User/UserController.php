<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Services\User\UserService;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserController extends Controller implements HasMiddleware
{
    protected $service;

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_users', only: ['index']),
            new Middleware('permission:create_users', only: ['create', 'store']),
            new Middleware('permission:update_users', only: ['edit', 'update']),
            new Middleware('permission:delete_users', only: ['destroy']),
        ];
    }

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $users = $this->service->getAll();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = $this->service->getRoles();

        return view('users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        $this->service->store($request);

        return redirect()
            ->route('users.index')
            ->with('success', 'User created successfully.');
    }

    public function edit($id)
    {
        $user  = $this->service->findById($id);
        $roles = $this->service->getRoles();

        return view('users.edit', compact('user', 'roles'));
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $this->service->update($request, $id);

        return redirect()
            ->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return redirect()
            ->route('users.index')
            ->with('success', 'User deleted successfully.');
    }
}
