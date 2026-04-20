<x-app-layout class="w-[75%] max-w-2xl pt-30">
    <x-form
        title="プロフィール設定"
        action="{{ route('profiles.update', $profile) }}"
        method="PATCH"
        enctype="multipart/form-data"
        class="gap-8"
    >
        <x-profile-image-upload-field :src="$profile->avatar" />
        <x-form.input-field field="nickname" :value="$profile->nickname" />
        <x-form.input-field
            field="postal_code"
            :value="$profile->postal_code"
        />
        <x-form.input-field field="address" :value="$profile->address" />
        <x-form.input-field field="building" :value="$profile->building" />

        <x-form.button class="mt-8">更新する</x-form.button>
    </x-form>
</x-app-layout>
