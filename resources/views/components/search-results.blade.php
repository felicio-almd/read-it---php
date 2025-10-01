<?php

declare(strict_types=1);

?>

<x-layouts.auth>
    <div class="min-h-screen bg-gray-50 dark:bg-slate-950">
        <x-navbar />
        <div class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-2xl bg-white shadow-sm dark:bg-slate-900 dark:shadow-slate-950/50">
                <div
                    class="border-b border-gray-100 bg-gradient-to-r from-violet-50 to-purple-50 px-6 py-5 dark:border-slate-700 dark:from-indigo-900/20 dark:to-purple-900/20"
                >
                    <div class="flex items-center gap-3">
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-lg bg-violet-500 dark:bg-indigo-600"
                        >
                            <x-lucide-search class="h-5 w-5 text-white" />
                        </div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                            Resultados da pesquisa por:
                            <span class="text-indigo-600 dark:text-indigo-400">"{{ $query }}"</span>
                        </h1>
                    </div>
                </div>

                <div class="p-6">
                    {{-- Resultados de Comunidades --}}
                    @if ($subreddits->isNotEmpty())
                        <div class="mb-8">
                            <h2
                                class="mb-4 flex items-center gap-2 border-b border-gray-200 pb-2 text-lg font-semibold text-gray-800 dark:border-slate-700 dark:text-white"
                            >
                                <x-lucide-users class="h-5 w-5 text-violet-600 dark:text-indigo-400" />
                                Comunidades
                            </h2>
                            <div class="space-y-4 pt-4">
                                @foreach ($subreddits as $subreddit)
                                    <div
                                        class="flex items-center space-x-4 rounded-lg p-3 transition-colors hover:bg-gray-50 dark:hover:bg-slate-800"
                                    >
                                        <img
                                            src="{{ $subreddit->icon_image ?? 'https://api.dicebear.com/8.x/bottts/svg?seed=' . $subreddit->slug }}"
                                            alt="Ícone"
                                            class="h-12 w-12 rounded-full bg-gray-200 dark:bg-slate-700"
                                        />
                                        <div class="flex-1">
                                            <a
                                                href="{{ route('subreddits.show', $subreddit) }}"
                                                class="text-lg font-bold text-gray-900 hover:underline dark:text-indigo-400 dark:hover:text-indigo-300"
                                            >
                                                r/{{ $subreddit->name }}
                                            </a>
                                            <p class="text-sm text-gray-500 dark:text-slate-400">
                                                {{ $subreddit->member_count }} membros
                                            </p>
                                            <p class="mt-1 text-sm text-gray-600 dark:text-slate-300">
                                                {{ Str::limit($subreddit->description, 100) }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Resultados de Posts --}}
                    <div class="mb-8">
                        <h2
                            class="mb-4 flex items-center gap-2 border-b border-gray-200 pb-2 text-lg font-semibold text-gray-800 dark:border-slate-700 dark:text-white"
                        >
                            <x-lucide-file-text class="h-5 w-5 text-violet-600 dark:text-indigo-400" />
                            Posts
                        </h2>
                        <div class="space-y-4 pt-4">
                            @forelse ($posts as $post)
                                {{-- Reutiliza o seu componente de card de post --}}
                                <x-post-card :post="$post" />
                            @empty
                                <div class="py-12 text-center">
                                    <div
                                        class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 dark:bg-slate-800"
                                    >
                                        <x-lucide-search-x class="h-8 w-8 text-gray-400 dark:text-slate-500" />
                                    </div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                        Nenhum post encontrado
                                    </p>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-slate-400">
                                        Nenhum post encontrado para o termo "{{ $query }}".
                                    </p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- Links de Paginação para os Posts --}}
                    @if ($posts->hasPages())
                        <div class="mt-6 border-t border-gray-100 pt-6 dark:border-slate-700">
                            <div class="flex items-center justify-center">
                                {{-- O appends() garante que o termo de pesquisa seja mantido ao mudar de página --}}
                                <div class="pagination-dark">
                                    {{ $posts->appends(['query' => $query])->links() }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.auth>

<?php
