<?php

declare(strict_types=1);

?>
<x-layouts.auth>
    <div class="mx-auto max-w-2xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="rounded-lg bg-white p-6 shadow">
            <x-navbar />
            <h1 class="mb-6 text-2xl font-bold text-gray-900">Criar Nova Comunidade</h1>

            <form action="{{ route('subreddits.store') }}" method="POST">
                @csrf
                <div class="space-y-6">
                    {{-- Nome --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <span
                                class="inline-flex items-center rounded-l-md border border-r-0 border-gray-300 bg-gray-50 px-3 text-gray-500 sm:text-sm"
                            >
                                r/
                            </span>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                value="{{ old('name') }}"
                                class="block w-full min-w-0 flex-1 rounded-none rounded-r-md border-gray-300 px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            />
                        </div>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Descrição --}}
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Descrição</label>
                        <textarea
                            id="description"
                            name="description"
                            rows="4"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm"
                        >
{{ old('description') }}</textarea
                        >
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <a
                        href="{{ url()->previous() }}"
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
