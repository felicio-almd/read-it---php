<?php

declare(strict_types=1);

?>

<x-layouts.auth>
    <x-navbar />
    <div class="mx-auto min-h-screen bg-gray-50 px-4 py-8 sm:px-6 lg:px-8 dark:bg-slate-950">
        <div class="mx-auto max-w-2xl">
            <div class="overflow-hidden rounded-2xl bg-white shadow-sm dark:bg-slate-900 dark:shadow-slate-950/50">
                <div
                    class="border-b border-gray-100 bg-gradient-to-r from-violet-50 to-purple-50 px-6 py-5 dark:border-slate-700 dark:from-indigo-900/20 dark:to-purple-900/20"
                >
                    <div class="flex items-center gap-3">
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-lg bg-violet-500 dark:bg-indigo-600"
                        >
                            <x-lucide-file-plus class="h-5 w-5 text-white" />
                        </div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Criar Novo Post</h1>
                    </div>
                </div>

                <div class="p-6">
                    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-6">
                            <div>
                                <input type="hidden" name="subreddit_id" value="{{ $subreddit->id }}" />
                                <p class="mb-1 block text-sm font-medium text-gray-700 dark:text-slate-300">
                                    Comunidade
                                </p>
                                <p
                                    class="rounded-md bg-gray-100 px-3 py-2 text-sm font-semibold text-gray-800 dark:bg-slate-800 dark:text-indigo-400"
                                >
                                    r/{{ $subreddit->name }}
                                </p>
                                @error('subreddit_id')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-slate-300">
                                    Título
                                </label>
                                <input
                                    type="text"
                                    name="title"
                                    id="title"
                                    value="{{ old('title') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm transition-colors focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:border-slate-600 dark:bg-slate-800 dark:text-white dark:placeholder-slate-400 dark:focus:border-indigo-500"
                                    placeholder="Um título interessante..."
                                />
                                @error('title')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label
                                    for="content"
                                    class="block text-sm font-medium text-gray-700 dark:text-slate-300"
                                >
                                    Conteúdo
                                </label>
                                <textarea
                                    id="content"
                                    name="content"
                                    rows="8"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm transition-colors focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:border-slate-600 dark:bg-slate-800 dark:text-white dark:placeholder-slate-400 dark:focus:border-indigo-500"
                                    placeholder="Compartilhe suas ideias..."
                                >
{{ old('content') }}</textarea
                                >
                                @error('content')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="image" class="block text-sm font-medium text-gray-700 dark:text-slate-300">
                                    Imagem (opcional)
                                </label>
                                <input
                                    type="file"
                                    name="image"
                                    id="image"
                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:rounded-md file:border-0 file:bg-violet-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-violet-700 hover:file:bg-violet-100 dark:text-slate-400 dark:file:bg-indigo-900/50 dark:file:text-indigo-300 dark:hover:file:bg-indigo-900/70"
                                />
                                @error('image')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end gap-3">
                            <a
                                href="{{ route('subreddits.show', $subreddit) }}"
                                class="rounded-lg px-6 py-2.5 font-semibold text-gray-700 transition-colors hover:bg-gray-100 dark:text-slate-300 dark:hover:bg-slate-800"
                            >
                                Cancelar
                            </a>
                            <button
                                type="submit"
                                class="flex items-center gap-2 rounded-lg bg-indigo-600 px-6 py-2.5 font-semibold text-white transition-colors hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-offset-slate-900"
                            >
                                <x-lucide-send class="h-4 w-4" />
                                Publicar Post
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.auth>

<?php
