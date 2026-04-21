<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\Profile;
use Illuminate\Support\Arr;

class ProfileController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Profile $profile)
    {
        if (request('page') === 'buy') {
            $items = auth()->user()->orderedItems()->withExists('order')->get();
        } else {
            $items = auth()->user()->items()->withExists('order')->get();
        }

        return view('profiles.show', ['profile' => $profile, 'items' => $items]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profile $profile)
    {
        return view('profiles.edit', ['profile' => $profile]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProfileRequest $request, Profile $profile)
    {
        $validated = $request->validated();

        $profile->updateAvatar($request->file('avatar'));

        $profile->update(Arr::except($validated, ['avatar']));

        return redirect()->intended(route('profiles.show', ['profile' => $profile]));
    }
}
