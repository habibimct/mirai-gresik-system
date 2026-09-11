<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::withCount('users')
            ->orderBy('name')
            ->get();

        return view('settings.roles.index', compact('roles'));
    }


    public function create()
    {
        return view('settings.roles.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:roles,name',
            ],
        ]);

        Role::create([
            'name' => $validated['name'],
        ]);

        return redirect()
            ->route('settings.roles.index')
            ->with('success', 'Role berhasil ditambahkan.');
    }


    public function edit(Role $role)
    {
        return view('settings.roles.edit', compact('role'));
    }


    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:roles,name,' . $role->id,
            ],
        ]);

        $role->update([
            'name' => $validated['name'],
        ]);

        return redirect()
            ->route('settings.roles.index')
            ->with('success', 'Role berhasil diperbarui.');
    }


    public function destroy(Role $role)
    {
        if ($role->name === 'Super Admin') {

            return redirect()
                ->route('settings.roles.index')
                ->with('error', 'Role Super Admin tidak dapat dihapus.');

        }

        $role->delete();

        return redirect()
            ->route('settings.roles.index')
            ->with('success', 'Role berhasil dihapus.');
    }
}