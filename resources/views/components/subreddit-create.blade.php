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
                            <x-lucide-users class="h-5 w-5 text-white" />
                        </div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Criar Nova Comunidade</h1>
                    </div>
                </div>

                <div class="p-6">
                    <form action="{{ route('subreddits.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-slate-300">
                                    Nome
                                </label>
                                <input
                                    type="text"
                                    name="name"
                                    id="name"
                                    value="{{ old('name') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm transition-colors focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:border-slate-600 dark:bg-slate-800 dark:text-white dark:placeholder-slate-400 dark:focus:border-indigo-500"
                                    placeholder="Nome da comunidade"
                                />
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-slate-300">
                                    Slug
                                </label>
                                <input
                                    type="text"
                                    name="slug"
                                    id="slug"
                                    value="{{ old('slug') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm transition-colors focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:border-slate-600 dark:bg-slate-800 dark:text-white dark:placeholder-slate-400 dark:focus:border-indigo-500"
                                    placeholder="nome-da-comunidade"
                                />
                                @error('slug')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label
                                    for="description"
                                    class="block text-sm font-medium text-gray-700 dark:text-slate-300"
                                >
                                    Descrição
                                </label>
                                <textarea
                                    name="description"
                                    id="description"
                                    rows="4"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm transition-colors focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:border-slate-600 dark:bg-slate-800 dark:text-white dark:placeholder-slate-400 dark:focus:border-indigo-500"
                                    placeholder="Descreva sobre o que é sua comunidade..."
                                >
{{ old('description') }}</textarea
                                >
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="rules" class="block text-sm font-medium text-gray-700 dark:text-slate-300">
                                    Regras
                                </label>
                                <textarea
                                    name="rules"
                                    id="rules"
                                    rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm transition-colors focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:border-slate-600 dark:bg-slate-800 dark:text-white dark:placeholder-slate-400 dark:focus:border-indigo-500"
                                    placeholder="Defina as regras da comunidade..."
                                >
{{ old('rules') }}</textarea
                                >
                                @error('rules')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label
                                    for="banner_image"
                                    class="block text-sm font-medium text-gray-700 dark:text-slate-300"
                                >
                                    Imagem de Banner
                                </label>
                                <input
                                    type="file"
                                    name="banner_image"
                                    id="banner_image"
                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:rounded-md file:border-0 file:bg-violet-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-violet-700 hover:file:bg-violet-100 dark:text-slate-400 dark:file:bg-indigo-900/50 dark:file:text-indigo-300 dark:hover:file:bg-indigo-900/70"
                                />
                                @error('banner_image')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label
                                    for="icon_image"
                                    class="block text-sm font-medium text-gray-700 dark:text-slate-300"
                                >
                                    Imagem de Ícone
                                </label>
                                <input
                                    type="file"
                                    name="icon_image"
                                    id="icon_image"
                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:rounded-md file:border-0 file:bg-violet-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-violet-700 hover:file:bg-violet-100 dark:text-slate-400 dark:file:bg-indigo-900/50 dark:file:text-indigo-300 dark:hover:file:bg-indigo-900/70"
                                />
                                @error('icon_image')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end gap-3">
                            <a
                                href="/"
                                class="rounded-lg px-6 py-2.5 font-semibold text-gray-700 transition-colors hover:bg-gray-100 dark:text-slate-300 dark:hover:bg-slate-800"
                            >
                                Cancelar
                            </a>
                            <button
                                type="submit"
                                class="flex items-center gap-2 rounded-lg bg-indigo-600 px-6 py-2.5 font-semibold text-white transition-colors hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-offset-slate-900"
                            >
                                <x-lucide-plus class="h-4 w-4" />
                                Criar Comunidade
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.auth>

<?php
