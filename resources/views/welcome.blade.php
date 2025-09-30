<?php

declare(strict_types=1);

?>

<x-layouts.guest>
    <main class="mx-auto min-h-screen bg-gray-50">
        <x-navbar />
        <div class="flex w-full gap-6 px-4 py-8 sm:px-6 lg:px-8">
            <!-- Feed principal -->
            <x-feed>
                <div class="mb-6 flex flex-col gap-3">
                    <h1 class="text-3xl font-bold text-gray-900">
                        Olá,
                        <span class="bg-gradient-to-r from-violet-600 to-purple-600 bg-clip-text text-transparent">
                            @if (auth()->user())
                                {{ auth()->user()->name }}
                            @else
                                $user
                            @endif
                        </span>
                    </h1>
                    @if (auth()->user())
                        <p class="text-sm text-gray-500">Confira as estatísticas das comunidades que você segue</p>
                    @else
                        <p class="text-sm text-gray-500">Confira nossos melhores posts</p>
                    @endif
                </div>

                @isset($totalStats)
                    <div class="mb-8 grid grid-cols-1 gap-4 md:grid-cols-3">
                        <!-- Card 1 - Usuários -->
                        <div class="flex items-center gap-4 rounded-2xl bg-blue-50 p-6 transition-all hover:shadow-md">
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-500">
                                <x-lucide-users class="h-6 w-6 text-white" />
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-medium text-gray-600">Quantidade de usuários</p>
                                <p class="text-2xl font-bold text-gray-900">
                                    {{ number_format($totalStats['members']) }}
                                </p>
                            </div>
                        </div>

                        <!-- Card 2 - Posts -->
                        <div class="flex items-center gap-4 rounded-2xl bg-green-50 p-6 transition-all hover:shadow-md">
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-500">
                                <x-lucide-file-text class="h-6 w-6 text-white" />
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-medium text-gray-600">Quantidade de posts</p>
                                <p class="text-2xl font-bold text-gray-900">
                                    {{ number_format($totalStats['posts']) }}
                                </p>
                            </div>
                        </div>

                        <!-- Card 3 - Replies -->
                        <div
                            class="flex items-center gap-4 rounded-2xl bg-purple-50 p-6 transition-all hover:shadow-md"
                        >
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-500">
                                <x-lucide-message-square class="h-6 w-6 text-white" />
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-medium text-gray-600">Quantidade de replies</p>
                                <p class="text-2xl font-bold text-gray-900">
                                    {{ number_format($totalStats['comments']) }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endisset

                <!-- Posts -->
                <div class="rounded-2xl bg-white shadow-sm">
                    @if (auth()->user())
                        <h2 class="border-b border-gray-100 px-6 py-5 text-xl font-semibold text-gray-900">
                            Veja os últimos posts das comunidades que você segue
                        </h2>
                    @endif

                    <div class="divide-y divide-gray-100">
                        @forelse ($posts as $post)
                            <div class="p-6">
                                <x-post-card :post="$post" />
                            </div>
                        @empty
                            <div class="p-12 text-center">
                                <div
                                    class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-gray-100"
                                >
                                    <x-lucide-inbox class="h-8 w-8 text-gray-400" />
                                </div>
                                <p class="text-sm font-medium text-gray-900">Nenhum post ainda</p>
                                <p class="mt-1 text-sm text-gray-500">
                                    Ainda não há posts para mostrar. Seja o primeiro!
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Outros posts -->
                @isset($otherPosts)
                    @if ($otherPosts->isNotEmpty())
                        <div class="mt-6 rounded-2xl bg-white shadow-sm">
                            <h2 class="border-b border-gray-100 px-6 py-5 text-xl font-semibold text-gray-900">
                                Posts de outras comunidades
                            </h2>
                            <div class="divide-y divide-gray-100">
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
