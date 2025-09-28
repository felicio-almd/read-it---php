<?php

declare(strict_types=1);

?>
<header class="sticky top-0 z-50">
    <nav class="bg-white shadow-sm">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 justify-between">
                <div class="flex">
                    <div class="flex flex-shrink-0 items-center">
                        <a href="{{ route('home') }}" class="text-xl font-bold text-gray-800">read-it</a>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a
                            href="#"
                            class="inline-flex items-center border-b-2 border-indigo-500 px-1 pt-1 text-sm font-medium text-gray-900"
                        >
                            Home
                        </a>
                    </div>
                </div>

                <div class="flex items-center">
                    @guest
                        <a href="#" class="text-sm font-medium text-gray-500 hover:text-gray-700">Login</a>
                        <a
                            href="#"
                            class="ml-4 inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700"
                        >
                            Registrar
                        </a>
                    @endguest

                    @auth
                        <div class="flex items-center space-x-4">
                            <span class="text-sm font-medium text-gray-700">Olá, {{ auth()->user()->name }}</span>
                            <form method="POST" action="#">
                                @csrf
                                <button type="submit" class="text-sm font-medium text-gray-500 hover:text-gray-700">
                                    Sair
                                </button>
                            </form>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
</header>
<?php 
