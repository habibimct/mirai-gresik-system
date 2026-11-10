<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\Contracts\Encryption\DecryptException;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')
            ->latest()
            ->paginate(10);

        $roles = Role::orderBy('name')->get();

        $users->getCollection()->transform(function ($user) {
            try {
                $user->password_display_plain = $user->password_display
                    ? Crypt::decryptString($user->password_display)
                    : null;
            } catch (DecryptException $e) {
                $user->password_display_plain = null;
            }

            return $user;
        });

        return view('settings.users.index', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = Role::orderBy('name')->get();

        return view('settings.users.create', compact('roles'));
    }

    public function store(UserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'is_active' => $request->is_active,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        $user->forceFill([
            'password_display' => Crypt::encryptString($request->password),
        ])->save();

        return redirect()
            ->route('settings.users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        //
    }

    public function edit(User $user)
    {
        $roles = Role::orderBy('name')->get();

        return view('settings.users.edit', compact('user', 'roles'));
    }

    public function update(UserRequest $request, User $user)
    {
        $user->update([
            'name'      => $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'is_active' => $request->is_active,
        ]);

        if ($request->filled('password')) {
            $user->forceFill([
                'password' => Hash::make($request->password),
                'password_display' => Crypt::encryptString($request->password),
            ])->save();
        }

        $user->syncRoles([$request->role]);

        return redirect()
            ->route('settings.users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    public function generatePassword(User $user)
    {
        $password = Str::random(16);

        $user->forceFill([
            'password' => Hash::make($password),
            'password_display' => Crypt::encryptString($password),
        ])->save();

        return redirect()
            ->route('settings.users.index')
            ->with('success', 'Password untuk ' . $user->name . ' berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        // Mencegah Super Admin menghapus dirinya sendiri
        if (Auth::user()?->id === $user->id) {
            return redirect()
                ->route('settings.users.index')
                ->with('error', 'Anda tidak dapat menghapus akun yang sedang digunakan.');
        }

        $user->delete();

        return redirect()
            ->route('settings.users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
