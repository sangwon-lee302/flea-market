@props (['src' => 'avatars/default.jpg'])

<div>
    <div class="flex items-center gap-8">
        <x-profile-image id="preview" :src="$src" class="size-37.5" />
        <label class="btn btn-secondary"
            ><input
                type="file"
                name="avatar"
                accept=".jpeg, .jpg, .png"
                onchange="previewImage(event)"
                hidden
            />
            <p>画像を選択する</p>
        </label>
    </div>
    @error ('avatar')
        <p class="text-red-500">{{ $message }}</p>
    @enderror
</div>
