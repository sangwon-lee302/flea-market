<x-app-layout class="w-[90%] max-w-2xl pt-30">
    <x-form
        title="商品の出品"
        action="{{ route('items.store') }}"
        method="POST"
        class="flex flex-col gap-8"
        enctype="multipart/form-data"
        novalidate
    >
        <x-items.image-field :src="null"></x-items.image-field>
        <h2
            class="border-b border-gray-400 pb-2 text-2xl font-bold text-gray-500"
        >
            商品の詳細
        </h2>
        <label class="flex flex-col"
            ><span
                class="font-bold"
                >{{ __('validation.attributes.categories') }}</span
            >
            <div class="flex flex-wrap gap-8 p-8">
                @foreach ($categories as $value => $label)
                    <label
                        ><input
                            type="checkbox"
                            name="categories[]"
                            value="{{ $value }}"
                            hidden
                            class="peer"
                        /><span
                            class="btn btn-secondary rounded-full py-1 font-normal"
                            >{{ $label }}</span
                        ></label
                    >
                @endforeach
            </div>
            @error ('categories')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </label>
        <x-items.condition-select :conditions="$conditions" />
        <h2
            class="border-b border-gray-400 pb-2 text-2xl font-bold text-gray-500"
        >
            商品名と説明
        </h2>
        <x-form.input-field field="name" label="商品名" />
        <x-form.input-field field="brand_name" />
        <label for="description" class="flex flex-col"
            ><span
                class="font-bold"
                >{{ __('validation.attributes.description') }}</span
            ><textarea
                id="description"
                name="description"
                rows="5"
                class="rounded-sm border border-gray-500 p-2"
                >{{ old('description') }}</textarea
            >
            @error ('description')
                <p class="text-red-500">{{ $message }}</p>
            @enderror
        </label>
        <x-form.input-field field="price" class="pl-6">
            &yen;</x-form.input-field
        >
        <x-form.button class="mt-12">出品する</x-form.button>
    </x-form>
</x-app-layout>
