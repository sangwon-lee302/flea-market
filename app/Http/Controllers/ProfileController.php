<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Profile $profile)
    {
        if (request('page') === 'sell') {
            $items = Auth::user()?->items()->get() ?? collect([]);
        } else {
            $items = Auth::user()?->orderedItems()->get() ?? collect([]);
        }

        return view('profiles.show', compact('profile', 'items'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profile $profile)
    {
        return view('profiles.edit', compact('profile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProfileRequest $request, Profile $profile)
    {
        if ($request->hasFile('image')) {
            if ($profile->image_path) {
                Storage::disk('public')->delete($profile->image_path);
            }

            $path = $request->file('image')->store('images', 'public');

            $profile->update(['image_path' => $path]);
        }

        $profile->update($request->except('image'));

        return redirect()->route('profiles.show', compact('profile'));
    }
}
