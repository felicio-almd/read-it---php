<?php

declare(strict_types=1);

?>

<x-layouts.auth>
    <x-navbar />
    <div class="mx-auto max-w-2xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="rounded-lg bg-white p-6 shadow">
            <h1 class="mb-6 text-2xl font-bold text-gray-900">Criar Nova Comunidade</h1>

            <form action="{{ route('subreddits.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            value="{{ old('name') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm"
                        />
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
                        <input
                            type="text"
                            name="slug"
                            id="slug"
                            value="{{ old('slug') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm"
                        />
                        @error('slug')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea
                            name="description"
                            id="description"
                            rows="4"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm"
                        >
{{ old('description') }}</textarea
                        >
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="rules" class="block text-sm font-medium text-gray-700">Rules</label>
                        <textarea
                            name="rules"
                            id="rules"
                            rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm"
                        >
{{ old('rules') }}</textarea
                        >
                        @error('rules')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="banner_image" class="block text-sm font-medium text-gray-700">Banner image</label>
                        <input
                            type="file"
                            name="banner_image"
                            id="banner_image"
                            class="mt-1 block w-full text-sm text-gray-500"
                        />
                        @error('banner_image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="icon_image" class="block text-sm font-medium text-gray-700">Icon image</label>
                        <input
                            type="file"
                            name="icon_image"
                            id="icon_image"
                            class="mt-1 block w-full text-sm text-gray-500"
                        />
                        @error('icon_image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <a
                        href="/"
                        class="rounded-lg px-6 py-2 font-bold text-gray-700 transition-colors hover:bg-gray-100"
                    >
                        Cancelar
                    </a>
                    <button
                        type="submit"
                        class="ml-4 rounded-lg bg-indigo-600 px-6 py-2 font-bold text-white transition-colors hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none"
                    >
                        Criar Comunidade
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.auth>

<?php
