<?php

declare(strict_types=1);

?>

<header class="sticky top-0 z-50">
    <nav class="border border-white border-b-gray-100 bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <div class="flex">
                    <div class="flex flex-shrink-0 items-center">
                        <a href="/" class="text-2xl font-bold md:hidden">read-it</a>
                    </div>
                </div>

                <div class="flex h-10 items-center justify-center gap-4 space-x-4">
                    <div
                        x-data="{ open: false }"
                        class="relative m-0 flex h-full items-center rounded px-2 transition-colors duration-200 max-md:hidden"
                    >
                        <button @click="open = !open" class="m-0 rounded-full text-center hover:cursor-pointer">
                            <x-lucide-search class="h-5 w-5 text-gray-600" />
                        </button>

                        {{-- Caixa de pesquisa --}}
                        <div
                            x-show="open"
                            @click.away="open = false"
                            class="absolute right-0 mt-2 w-64 rounded-lg bg-white p-2 shadow-lg dark:bg-gray-800"
                        >
                            <input
                                type="text"
                                placeholder="Pesquisar..."
                                class="w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:ring focus:ring-blue-500 focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100"
                            />
                        </div>
                    </div>

                    <div class="m-0 flex h-full items-center max-md:hidden">
                        <x-theme-toggle />
                    </div>

                    @guest
                        <a
                            href="{{ route('login') }}"
                            class="m-0 rounded-lg bg-gray-400 p-2 text-center text-sm font-medium text-black transition-colors duration-200 hover:bg-gray-300"
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
                                            class="h-8 w-8 rounded-full border border-gray-300 dark:border-gray-600"
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
