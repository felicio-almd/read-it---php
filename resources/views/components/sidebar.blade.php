<?php

declare(strict_types=1);

?>

<aside
    class="sticky top-0 left-0 hidden h-screen flex-shrink-0 flex-col space-y-4 border border-white !border-r-gray-100 bg-white p-8 lg:flex lg:w-1/5 dark:border-slate-700 dark:!border-r-slate-600 dark:bg-slate-900"
>
    <div class="flex flex-shrink-0 items-center py-4">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-indigo-400">read-it</h1>
    </div>

    <a
        href="{{ route('home') }}"
        class="flex items-center gap-2 pt-3 pb-5 font-semibold text-gray-600 transition-colors hover:text-indigo-600 dark:text-slate-300 dark:hover:text-indigo-400"
    >
        <x-lucide-home class="h-4 w-4" />
        Home
    </a>

    <div class="">
        <!-- Card de Comunidades Populares -->

        <h3 class="mb-5 pt-2 text-sm font-bold text-gray-600 dark:text-slate-400">
            @auth
                Minhas Comunidades
            @else
                Comunidades Populares
            @endauth
        </h3>
        <ul class="flex flex-col gap-3">
            @forelse ($subreddits as $subreddit)
                <a
                    href="{{ route('subreddits.show', $subreddit->slug) }}"
                    @class([
                        'active: flex items-center space-x-3 rounded-lg p-2 transition-colors hover:bg-violet-200 focus:bg-violet-100 dark:hover:bg-slate-800',
                        'bg-violet-200 dark:bg-indigo-900/50' =>
                            request()->routeIs('subreddits.show') && request()->route('subreddit')->slug === $subreddit->slug,
                    ])
                >
                    <img
                        src="{{ asset('storage/' . $subreddit->icon_image) ?? 'https://api.dicebear.com/8.x/bottts/svg?seed=' . $subreddit->slug }}"
                        alt="Icone"
                        class="h-6 w-6 rounded-full bg-gray-200 dark:bg-slate-700"
                    />
                    <div class="flex w-full justify-between p-2">
                        <h2 class="text-sm font-bold text-gray-900 dark:text-white">r/{{ $subreddit->name }}</h2>
                        <p
                            class="w-1/4 rounded-xl border border-violet-400 bg-violet-300 text-center text-xs font-bold text-black max-xl:hidden dark:border-indigo-500 dark:bg-indigo-600 dark:text-white"
                        >
                            {{ $subreddit->member_count }}
                        </p>
                    </div>
                </a>
            @empty
                <li class="text-sm text-gray-500 dark:text-slate-400">Nenhuma comunidade encontrada.</li>
            @endforelse
        </ul>
    </div>
    @auth
        <a
            href="{{ route('subreddits.create') }}"
            class="mt-4 flex items-center gap-2 rounded-xl border border-gray-300 bg-gray-200 p-4 text-sm font-bold transition-colors hover:cursor-pointer hover:bg-gray-300 dark:border-slate-600 dark:bg-slate-800 dark:text-white dark:hover:bg-slate-700"
        >
            Criar Comunidade
            <x-lucide-plus class="h-4 w-4" />
        </a>
    @endauth

    <div
        class="rounded-lg bg-white p-4 text-xs text-gray-500 shadow dark:bg-slate-800 dark:text-slate-400 dark:shadow-slate-900/50"
    >
        <p>read-it Inc. © {{ date('Y') }}. All rights reserved.</p>
    </div>
</aside>

<?php
