<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class ManagerAccountController extends Controller
{
    public function create(): View
    {
        return view('admin.managers.create', [
            'managers' => User::query()
                ->where('role', User::ROLE_MANAGER)
                ->latest()
                ->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => User::ROLE_MANAGER,
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'Manager account created successfully.');
    }

    public function edit(User $manager): View
    {
        abort_if($manager->role !== User::ROLE_MANAGER, 403);

        return view('admin.managers.edit', [
            'manager' => $manager,
            'managers' => User::query()
                ->where('role', User::ROLE_MANAGER)
                ->latest()
                ->get(),
        ]);
    }

    public function update(Request $request, User $manager): RedirectResponse
    {
        abort_if($manager->role !== User::ROLE_MANAGER, 403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class.',email,'.$manager->id],
            'password' => ['nullable', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $manager->name = $validated['name'];
        $manager->email = $validated['email'];

        if ($validated['password']) {
            $manager->password = Hash::make($validated['password']);
        }

        $manager->save();

        return back()->with('status', 'Manager account updated successfully.');
    }

    public function destroy(User $manager): RedirectResponse
    {
        abort_if($manager->role !== User::ROLE_MANAGER, 403);

        $manager->delete();

        return back()->with('status', 'Manager account deleted successfully.');
    }
}
