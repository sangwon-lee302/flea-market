<div class="flex flex-col">
    <label
        for="preview"
        class="font-bold"
        >{{ __('validation.attributes.image') }}</label
    >
    <div class="group relative h-40">
        <img
            id="preview"
            src="{{ asset('storage/'.$displaySrc) }}"
            alt="{{ __('validation.attributes.image') }}"
            class="h-full w-full rounded-md border border-dashed object-contain"
        />
        <label
            class="absolute inset-0 flex cursor-pointer items-center justify-center transition-all hover:bg-gray-50/50"
            ><input
                type="file"
                name="image"
                accept=".jpeg, .jpg, .png"
                onchange="previewImage(event)"
                required
                hidden
                class="peer"
            />
            <p class="btn btn-secondary peer-valid:hidden">画像を選択する</p></label
        >
    </div>
    @error ('image')
        <p class="text-red-500">{{ $message }}</p>
    @enderror
</div>
