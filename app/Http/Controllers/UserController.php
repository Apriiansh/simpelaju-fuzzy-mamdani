<?php

namespace App\Http\Controllers;

use App\Models\Kelurahan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('kelurahan')->orderBy('name')->get();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelurahan = Kelurahan::orderBy('nama')->get();
        return view('users.create', compact('kelurahan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,operator,camat',
            'kelurahan_id' => [
                Rule::requiredIf($request->role === 'operator'),
                'nullable',
                'exists:kelurahan,id',
            ],
        ]);

        $validated['password'] = bcrypt($validated['password']);

        if ($validated['role'] !== 'operator') {
            $validated['kelurahan_id'] = null;
        }

        User::create($validated);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $kelurahan = Kelurahan::orderBy('nama')->get();
        return view('users.edit', compact('user', 'kelurahan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8',
            'role' => 'required|in:admin,operator,camat',
            'kelurahan_id' => [
                Rule::requiredIf($request->role === 'operator'),
                'nullable',
                'exists:kelurahan,id',
            ],
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        if ($validated['role'] !== 'operator') {
            $validated['kelurahan_id'] = null;
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}
