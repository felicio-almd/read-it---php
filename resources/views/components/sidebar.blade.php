<?php

declare(strict_types=1);

?>

<aside
    class="sticky top-0 left-0 hidden h-screen flex-shrink-0 flex-col space-y-4 border border-white !border-r-gray-100 bg-white p-8 lg:flex lg:w-1/5"
>
    <div class="flex flex-shrink-0 items-center py-4">
        <h1 class="text-2xl font-bold text-gray-800">read-it</h1>
    </div>

    <a href="{{ route('home') }}" class="flex items-center gap-2 pt-3 pb-5 font-semibold text-gray-600">
        <x-lucide-home class="h-4 w-4" />
        Home
    </a>

    <div class="">
        <!-- Card de Comunidades Populares -->

        <h3 class="mb-5 pt-2 text-sm font-bold text-gray-600">
            @auth
                Minhas Comunidades
            @else
                Comunidades Populares
            @endauth
        </h3>
        <ul class="flex flex-col gap-5">
            @forelse ($subreddits as $subreddit)
                <li class="flex items-center space-x-3 rounded-md p-2 hover:bg-gray-100">
                    <img
                        src="{{ $subreddit->icon_image ?? 'https://api.dicebear.com/8.x/bottts/svg?seed=' . $subreddit->slug }}"
                        alt="Icone"
                        class="h- w-5 rounded-full bg-gray-200"
                    />
                    <div class="flex w-full justify-between p-2">
                        <a
                            href="{{ route('subreddits.show', $subreddit->slug) }}"
                            class="text-sm font-bold hover:underline"
                        >
                            r/{{ $subreddit->name }}
                        </a>
                        <p
                            class="w-1/4 rounded-xl border border-violet-400 bg-violet-300 text-center text-xs font-bold text-black max-xl:hidden"
                        >
                            {{ $subreddit->member_count }}
                        </p>
                    </div>
                </li>
            @empty
                <li class="text-sm text-gray-500">Nenhuma comunidade encontrada.</li>
            @endforelse
        </ul>
    </div>
    @auth
        <a
            href="{{ route('subreddits.create') }}"
            class="mt-4 flex items-center gap-2 rounded-xl border border-gray-300 bg-gray-200 p-4 text-sm font-bold hover:cursor-pointer"
        >
            Criar Comunidade
            <x-lucide-plus class="h-4 w-4" />
        </a>
    @endauth

    <!-- Footer -->
    <div class="rounded-lg bg-white p-4 text-xs text-gray-500 shadow">
        <p>read-it Inc. © {{ date('Y') }}. All rights reserved.</p>
    </div>
</aside>

<?php
