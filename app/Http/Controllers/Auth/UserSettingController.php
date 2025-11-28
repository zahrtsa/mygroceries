<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserSettingController extends Controller
{
    public function edit(User $setting)
    {
        // kalau mau selalu pakai user yang login:
        $user = auth()->user();

        return view('setting.edit', [
            'user' => $user,
        ]);
    }

    public function update(Request $request, User $setting)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'pendapatan_bulanan' => 'nullable|numeric',
            'budget_bulanan' => 'nullable|numeric',
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->fill([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'pendapatan_bulanan' => $validated['pendapatan_bulanan'] ?? null,
            'budget_bulanan' => $validated['budget_bulanan'] ?? null,
        ]);

        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }

        $user->save();

        return redirect()
            ->route('settings.edit', $user->id)
            ->with('success', 'Profil berhasil diperbarui.');
    }
}
