<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PermissionController extends Controller
{
    /**
     * Menampilkan daftar permission.
     */
    public function index()
    {
        $permissions = Permission::withCount('roles')
            ->orderBy('name')
            ->get();

        return view('settings.permissions.index', compact('permissions'));
    }

    /**
     * Form tambah permission.
     */
    public function create()
    {
        return view('settings.permissions.create');
    }

    /**
     * Menyimpan permission baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('permissions', 'name'),
            ],
        ], [
            'name.required' => 'Nama permission wajib diisi.',
            'name.unique' => 'Permission tersebut sudah ada.',
        ]);

        Permission::create([
            'name' => $validated['name'],
            'guard_name' => 'web',
        ]);

        return redirect()
            ->route('settings.permissions.index')
            ->with('success', 'Permission berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail permission.
     */
    public function show(Permission $permission)
    {
        $permission->load('roles');

        return view(
            'settings.permissions.show',
            compact('permission')
        );
    }

    /**
     * Form edit permission.
     */
    public function edit(Permission $permission)
    {
        return view(
            'settings.permissions.edit',
            compact('permission')
        );
    }

    /**
     * Memperbarui permission.
     */
    public function update(
        Request $request,
        Permission $permission
    ) {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('permissions', 'name')
                    ->ignore($permission->id),
            ],
        ], [
            'name.required' => 'Nama permission wajib diisi.',
            'name.unique' => 'Permission tersebut sudah ada.',
        ]);

        $permission->update([
            'name' => $validated['name'],
        ]);

        return redirect()
            ->route('settings.permissions.index')
            ->with('success', 'Permission berhasil diperbarui.');
    }

    /**
     * Menghapus permission.
     */
    public function destroy(Permission $permission)
    {
        /*
         * Lepaskan permission dari seluruh role
         * sebelum permission dihapus.
         */
        $permission->roles()->detach();

        $permission->delete();

        return redirect()
            ->route('settings.permissions.index')
            ->with('success', 'Permission berhasil dihapus.');
    }
}