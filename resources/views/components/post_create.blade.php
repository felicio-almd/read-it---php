<?php

declare(strict_types=1);

?>
<x-layouts.auth>
    <div class="mx-auto max-w-2xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="rounded-lg bg-white p-6 shadow">
            <h1 class="mb-6 text-2xl font-bold text-gray-900">Criar Novo Post</h1>

            <form action="{{ route('posts.store') }}" method="POST">
                @csrf
                <div class="space-y-6">
                    {{-- Selecionar Comunidade --}}
                    <div>
                        <label for="subreddit_id" class="block text-sm font-medium text-gray-700">Comunidade</label>
                        <select
                            id="subreddit_id"
                            name="subreddit_id"
                            class="mt-1 block w-full rounded-md border-gray-300 py-2 pr-10 pl-3 text-base focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none sm:text-sm"
                        >
                            @foreach ($subreddits as $subreddit)
                                <option value="{{ $subreddit->id }}">{{ $subreddit->name }}</option>
                            @endforeach
                        </select>
                        @error('subreddit_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Título --}}
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Título</label>
                        <input
                            type="text"
                            name="title"
                            id="title"
                            value="{{ old('title') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm"
                        />
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Conteúdo --}}
                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700">Conteúdo</label>
                        <textarea
                            id="content"
                            name="content"
                            rows="8"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm"
                        >
{{ old('content') }}</textarea
                        >
                        @error('content')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <button
                        type="submit"
                        class="rounded-lg bg-indigo-600 px-6 py-2 font-bold text-white transition-colors hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none"
                    >
                        Publicar Post
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.auth>
<?php 
