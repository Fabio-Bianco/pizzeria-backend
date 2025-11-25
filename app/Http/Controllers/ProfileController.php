<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        // Gestione upload immagine profilo
        if ($request->hasFile('avatar')) {
            // Elimina vecchia immagine se esiste
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            
            // Salva nuova immagine
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        } else {
            // Mantieni avatar esistente se non viene caricato uno nuovo
            unset($data['avatar']);
        }

        // Se l'email cambia, azzera la verifica
        if ($data['email'] !== $user->email) {
            $user->forceFill([
                'name' => $data['name'],
                'email' => $data['email'],
                'email_verified_at' => null,
                'avatar' => $data['avatar'] ?? $user->avatar,
            ])->save();
        } else {
            $user->update($data);
        }

        return redirect()->route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request)
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'string'],
        ]);

        $user = $request->user();

        if (! Hash::check($request->input('password'), $user->password)) {
            return back()->withErrors([
                'password' => __('auth.password')
            ], 'userDeletion')->withInput();
        }

        Auth::logout();
        
        // Elimina avatar prima di cancellare l'utente
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }
        
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Account eliminato.');
    }
}
