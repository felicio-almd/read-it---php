<?php

declare(strict_types=1);

?>

<x-layouts.guest>
    <main class="mx-auto">
        <x-navbar />
        <div class="flex w-full gap-10 px-4 py-8 sm:px-6 lg:px-8">
            <x-feed>
                <div class="mb-3 flex flex-col gap-5 pb-5">
                    <h1 class="text-2xl font-bold">
                        Olá,
                        <span class="text-violet-700">
                            @if (auth()->user())
                                ${{ auth()->user()->name }}
                            @else
                                $user
                            @endif
                        </span>
                    </h1>
                    @if (auth()->user())
                        <p class="font-semibold text-gray-600">
                            Confira as estatísticas das comunidades que você segue
                        </p>
                    @else
                        <p class="text-2xl font-semibold text-gray-600">Confira nossos melhores posts</p>
                    @endif
                </div>

                @isset($totalStats)
                    <div class="flex w-full justify-between max-md:flex-col">
                        <div class="mb-4 flex items-center gap-4 rounded-lg bg-white p-8 shadow md:w-[31%]">
                            <x-lucide-building-2 class="h-10 w-10" />
                            <div class="space-y-2 text-sm text-gray-600">
                                <p class="m-0 font-semibold text-gray-700">Quantidade de usuários</p>
                                <p class="m-0 text-2xl font-bold">
                                    {{ number_format($totalStats['members']) }}
                                </p>
                            </div>
                        </div>
                        <div class="mb-4 flex items-center gap-4 rounded-lg bg-white p-8 shadow md:w-[31%]">
                            <x-lucide-building-2 class="h-10 w-10" />
                            <div class="space-y-2 text-sm text-gray-600">
                                <p class="m-0 font-semibold text-gray-700">Quantidade de posts</p>
                                <p class="m-0 text-2xl font-bold">
                                    {{ number_format($totalStats['posts']) }}
                                </p>
                            </div>
                        </div>
                        <div class="mb-4 flex items-center gap-4 rounded-lg bg-white p-8 shadow md:w-[31%]">
                            <x-lucide-building-2 class="h-10 w-10" />
                            <div class="space-y-2 text-sm text-gray-600">
                                <p><strong>Quantidade de replies</strong></p>
                                <p class="m-0 text-2xl font-bold">
                                    {{ number_format($totalStats['comments']) }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endisset

                <div class="rounded bg-white px-8 pb-4 shadow">
                    @if (auth()->user())
                        <h1 class="py-8 text-2xl font-semibold">
                            Veja os últimos posts das comunidades que você segue
                        </h1>
                    @else
                        <h1 class="py-4 text-2xl font-semibold"></h1>
                    @endif

                    @forelse ($posts as $post)
                        <x-post-card :post="$post" class="mb-4" />
                    @empty
                        <div class="rounded-lg bg-white p-4 text-center shadow">
                            <p class="text-gray-500">Ainda não há posts para mostrar. Seja o primeiro!</p>
                        </div>
                    @endforelse
                </div>
                <div>
                    @isset($otherPosts)
                        @if ($otherPosts->isNotEmpty())
                            <div class="mt-8 rounded bg-white px-8 pb-4 shadow">
                                <h1 class="py-8 text-2xl font-semibold">Posts de outras comunidades</h1>

                                @foreach ($otherPosts as $post)
                                    <x-post-card :post="$post" class="mb-4" />
                                @endforeach
                            </div>
                        @endif
                    @endisset
                </div>
            </x-feed>
        </div>
    </main>
</x-layouts.guest>

<?php
