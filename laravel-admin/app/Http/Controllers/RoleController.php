<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    public function index()
    {
        \Gate::authorize('view', 'roles');

        return RoleResource::collection(Role::all());
    }

    public function store(Request $request)
    {
        \Gate::authorize('edit', 'roles');

        $role = Role::create($request->only('name'));

        if ($permissions = $request->permissions) {
            foreach ($permissions as $permission_id) {
                \DB::table('role_permissions')->insert([
                    'role_id' => $role->id,
                    'permission_id' => $permission_id
                ]);
            }
        }

        return response(new RoleResource($role), Response::HTTP_CREATED);
    }

    public function show(string $id)
    {
        \Gate::authorize('view', 'roles');

        return new RoleResource(Role::find($id));
    }

    public function update(Request $request, string $id)
    {
        \Gate::authorize('edit', 'roles');

        $role = Role::find($id);

        $role->update($request->only('name'));

        \DB::table('role_permissions')->where('role_id', $role->id)->delete();

        if ($permissions = $request->permissions) {
            foreach ($permissions as $permission_id) {
                \DB::table('role_permissions')->insert([
                    'role_id' => $role->id,
                    'permission_id' => $permission_id
                ]);
            }
        }

        return response(new RoleResource($role), Response::HTTP_ACCEPTED);
    }

    public function destroy(string $id)
    {
        \Gate::authorize('edit', 'roles');

        \DB::table('role_permissions')->where('role_id', $id)->delete();

        Role::destroy($id);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
