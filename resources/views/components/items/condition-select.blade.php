@props (['conditions' => []])

<div class="flex flex-col">
    <label
        for="condition"
        class="font-bold"
        >{{ __('validation.attributes.condition') }}</label
    >
    <select
        id="condition"
        name="condition"
        class="cursor-pointer rounded-sm border border-gray-500 p-2"
    >
        <option value="" disabled hidden @selected (! old('condition'))
            >選択してください
        </option>
        @foreach ($conditions as $value => $label)
            <option value="{{ $value }}" @selected (old('condition') == $value)
                >{{ $label }}
            </option>
        @endforeach
    </select>
    @error ('condition')
        <p class="text-red-500">{{ $message }}</p>
    @enderror
</div>
