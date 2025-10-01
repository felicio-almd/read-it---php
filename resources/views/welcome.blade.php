<?php

declare(strict_types=1);

?>

<x-layouts.guest>
    <main class="mx-auto min-h-screen bg-gray-50 dark:bg-slate-950">
        <x-navbar />
        <div class="flex w-full gap-6 px-4 py-8 sm:px-6 lg:px-8">
            <!-- Feed principal -->
            <x-feed>
                <div class="mb-6 flex flex-col gap-3">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                        Olá,
                        <span
                            class="bg-gradient-to-r from-violet-600 to-purple-600 bg-clip-text text-transparent dark:from-indigo-400 dark:to-purple-400"
                        >
                            @if (auth()->user())
                                <span>$</span>
                                {{ auth()->user()->name }}
                            @else
                                $user
                            @endif
                        </span>
                    </h1>
                    @if (auth()->user())
                        <p class="text-sm text-gray-500 dark:text-slate-400">
                            Confira as estatísticas das comunidades que você segue
                        </p>
                    @else
                        <p class="text-sm text-gray-500 dark:text-slate-400">Confira nossos melhores posts</p>
                    @endif
                </div>

                @isset($totalStats)
                    <div class="mb-8 grid grid-cols-1 gap-4 md:grid-cols-3">
                        <!-- Card 1 - Usuários -->
                        <div
                            class="flex items-center gap-4 rounded-2xl bg-blue-50 p-6 transition-all hover:shadow-md dark:bg-blue-900/20 dark:hover:bg-blue-900/30"
                        >
                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-500 dark:bg-blue-600"
                            >
                                <x-lucide-users class="h-6 w-6 text-white" />
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-600 dark:text-slate-400">
                                    Quantidade de usuários
                                </p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                    {{ number_format($totalStats['members']) }}
                                </p>
                            </div>
                        </div>

                        <!-- Card 2 - Posts -->
                        <div
                            class="flex items-center gap-4 rounded-2xl bg-green-50 p-6 transition-all hover:shadow-md dark:bg-green-900/20 dark:hover:bg-green-900/30"
                        >
                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-500 dark:bg-green-600"
                            >
                                <x-lucide-file-text class="h-6 w-6 text-white" />
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-600 dark:text-slate-400">Quantidade de posts</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                    {{ number_format($totalStats['posts']) }}
                                </p>
                            </div>
                        </div>

                        <!-- Card 3 - Replies -->
                        <div
                            class="flex items-center gap-4 rounded-2xl bg-purple-50 p-6 transition-all hover:shadow-md dark:bg-purple-900/20 dark:hover:bg-purple-900/30"
                        >
                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-500 dark:bg-purple-600"
                            >
                                <x-lucide-message-square class="h-6 w-6 text-white" />
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-600 dark:text-slate-400">
                                    Quantidade de replies
                                </p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                    {{ number_format($totalStats['comments']) }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endisset

                <!-- Posts -->
                <div class="rounded-2xl bg-white shadow-sm dark:bg-slate-900 dark:shadow-slate-950/50">
                    @if (auth()->user())
                        <h2
                            class="border-b border-gray-100 px-6 py-5 text-xl font-semibold text-gray-900 dark:border-slate-700 dark:text-white"
                        >
                            Veja os últimos posts das comunidades que você segue
                        </h2>
                    @endif

                    <div class="divide-y divide-gray-100 dark:divide-slate-700">
                        @forelse ($posts as $post)
                            <div class="p-6">
                                <x-post-card :post="$post" />
                            </div>
                        @empty
                            <div class="p-12 text-center">
                                <div
                                    class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 dark:bg-slate-800"
                                >
                                    <x-lucide-inbox class="h-8 w-8 text-gray-400 dark:text-slate-500" />
                                </div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">Nenhum post ainda</p>
                                <p class="mt-1 text-sm text-gray-500 dark:text-slate-400">
                                    Ainda não há posts para mostrar. Seja o primeiro!
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Outros posts -->
                @isset($otherPosts)
                    @if ($otherPosts->isNotEmpty())
                        <div class="mt-6 rounded-2xl bg-white shadow-sm dark:bg-slate-900 dark:shadow-slate-950/50">
                            <h2
                                class="border-b border-gray-100 px-6 py-5 text-xl font-semibold text-gray-900 dark:border-slate-700 dark:text-white"
                            >
                                Posts de outras comunidades
                            </h2>
                            <div class="divide-y divide-gray-100 dark:divide-slate-700">
                                @foreach ($otherPosts as $post)
                                    <div class="p-6">
                                        <x-post-card :post="$post" />
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endisset
            </x-feed>
        </div>
    </main>
</x-layouts.guest>

<?php
