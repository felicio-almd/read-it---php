<?php

declare(strict_types=1);

?>

<header class="sticky top-0 z-5">
    <nav
        class="border border-white border-b-gray-100 bg-white dark:border-slate-700 dark:border-b-slate-600 dark:bg-slate-900"
    >
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <div class="flex">
                    <div class="flex flex-shrink-0 items-center">
                        <a href="/" class="text-2xl font-bold text-gray-900 md:hidden dark:text-indigo-400">read-it</a>
                    </div>
                </div>

                <div class="flex h-10 items-center justify-center gap-4 space-x-4">
                    <div class="m-0 flex flex-1 items-center justify-center max-md:justify-end">
                        <div class="w-full max-w-lg max-md:w-2/3">
                            <form action="{{ route('search') }}" method="GET" class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <x-lucide-search class="h-5 w-5 text-gray-400 dark:text-slate-400" />
                                </span>
                                <input
                                    type="text"
                                    name="query"
                                    placeholder="Pesquisar..."
                                    class="w-full rounded-md border-gray-300 bg-gray-100 py-2 pr-4 pl-10 text-sm text-gray-900 placeholder-gray-500 focus:border-indigo-500 focus:ring-indigo-500 dark:border-slate-600 dark:bg-slate-800 dark:text-white dark:placeholder-slate-400 dark:focus:border-indigo-500 dark:focus:ring-indigo-500"
                                    value="{{ request('query') }}"
                                />
                            </form>
                        </div>
                    </div>

                    <div class="m-0 flex h-full items-center">
                        <x-theme-toggle />
                    </div>

                    @guest
                        <a
                            href="{{ route('login') }}"
                            class="m-0 rounded-lg bg-gray-400 p-2 text-center text-sm font-medium text-black transition-colors duration-200 hover:bg-gray-300 dark:bg-indigo-600 dark:text-white dark:hover:bg-indigo-700"
                        >
                            Login
                        </a>
                    @endguest

                    @auth
                        <div class="m-0 sm:flex sm:items-center">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="flex items-center focus:outline-none">
                                        <img
                                            src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}"
                                            alt="{{ Auth::user()->name }}"
                                            class="h-8 w-8 rounded-full border border-gray-300 dark:border-slate-600"
                                        />
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <x-dropdown-link :href="route('profile.edit')">
                                        {{ __('Profile') }}
                                    </x-dropdown-link>

                                    <!-- Authentication -->
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-dropdown-link
                                            :href="route('logout')"
                                            onclick="event.preventDefault(); this.closest('form').submit();"
                                        >
                                            {{ __('Log Out') }}
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
</header>

<?php
