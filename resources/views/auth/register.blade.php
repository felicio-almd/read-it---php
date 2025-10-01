<?php

declare(strict_types=1);

?>

<x-guest-layout>
    <div
        class="flex min-h-screen w-full items-center justify-center bg-gradient-to-br from-violet-50 via-purple-50 to-pink-50 px-4 py-12 sm:px-6 lg:px-8 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900"
    >
        <div class="w-full max-w-md">
            <div class="mb-8 text-center">
                <div
                    class="mb-4 inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-violet-600 to-purple-600 shadow-lg dark:from-indigo-600 dark:to-purple-600"
                >
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"
                        />
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Crie sua conta</h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-slate-400">Junte-se ao READ IT</p>
            </div>

            <div class="rounded-2xl bg-white p-8 shadow-xl dark:bg-slate-900 dark:shadow-slate-950/50">
                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-900 dark:text-white">
                            Nome completo
                        </label>
                        <div class="relative mt-2">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg
                                    class="h-5 w-5 text-gray-400 dark:text-slate-500"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                    />
                                </svg>
                            </div>
                            <input
                                id="name"
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                required
                                autofocus
                                autocomplete="name"
                                class="block w-full rounded-xl border-gray-300 py-3 pr-3 pl-10 text-gray-900 placeholder-gray-400 transition-colors focus:border-violet-500 focus:ring-violet-500 sm:text-sm dark:border-slate-600 dark:bg-slate-800 dark:text-white dark:placeholder-slate-500 dark:focus:border-indigo-500 dark:focus:ring-indigo-500"
                                placeholder="João Silva"
                            />
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <label for="username" class="block text-sm font-semibold text-gray-900 dark:text-white">
                            Username
                        </label>
                        <div class="relative mt-2">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg
                                    class="h-5 w-5 text-gray-400 dark:text-slate-500"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"
                                    />
                                </svg>
                            </div>
                            <input
                                id="username"
                                type="text"
                                name="username"
                                value="{{ old('username') }}"
                                required
                                autocomplete="username"
                                class="block w-full rounded-xl border-gray-300 py-3 pr-3 pl-10 text-gray-900 placeholder-gray-400 transition-colors focus:border-violet-500 focus:ring-violet-500 sm:text-sm dark:border-slate-600 dark:bg-slate-800 dark:text-white dark:placeholder-slate-500 dark:focus:border-indigo-500 dark:focus:ring-indigo-500"
                                placeholder="joaosilva"
                            />
                        </div>
                        <x-input-error :messages="$errors->get('username')" class="mt-2" />
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-900 dark:text-white">
                            Email
                        </label>
                        <div class="relative mt-2">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg
                                    class="h-5 w-5 text-gray-400 dark:text-slate-500"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"
                                    />
                                </svg>
                            </div>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autocomplete="email"
                                class="block w-full rounded-xl border-gray-300 py-3 pr-3 pl-10 text-gray-900 placeholder-gray-400 transition-colors focus:border-violet-500 focus:ring-violet-500 sm:text-sm dark:border-slate-600 dark:bg-slate-800 dark:text-white dark:placeholder-slate-500 dark:focus:border-indigo-500 dark:focus:ring-indigo-500"
                                placeholder="seu@email.com"
                            />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-900 dark:text-white">
                            Senha
                        </label>
                        <div class="relative mt-2">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg
                                    class="h-5 w-5 text-gray-400 dark:text-slate-500"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                                    />
                                </svg>
                            </div>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="new-password"
                                class="block w-full rounded-xl border-gray-300 py-3 pr-3 pl-10 text-gray-900 placeholder-gray-400 transition-colors focus:border-violet-500 focus:ring-violet-500 sm:text-sm dark:border-slate-600 dark:bg-slate-800 dark:text-white dark:placeholder-slate-500 dark:focus:border-indigo-500 dark:focus:ring-indigo-500"
                                placeholder="••••••••"
                            />
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div>
                        <label
                            for="password_confirmation"
                            class="block text-sm font-semibold text-gray-900 dark:text-white"
                        >
                            Confirmar senha
                        </label>
                        <div class="relative mt-2">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg
                                    class="h-5 w-5 text-gray-400 dark:text-slate-500"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>
                            </div>
                            <input
                                id="password_confirmation"
                                type="password"
                                name="password_confirmation"
                                required
                                autocomplete="new-password"
                                class="block w-full rounded-xl border-gray-300 py-3 pr-3 pl-10 text-gray-900 placeholder-gray-400 transition-colors focus:border-violet-500 focus:ring-violet-500 sm:text-sm dark:border-slate-600 dark:bg-slate-800 dark:text-white dark:placeholder-slate-500 dark:focus:border-indigo-500 dark:focus:ring-indigo-500"
                                placeholder="••••••••"
                            />
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <button
                        type="submit"
                        class="flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-violet-600 to-purple-600 px-4 py-3 text-sm font-semibold text-white shadow-lg transition-all hover:from-violet-700 hover:to-purple-700 focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 focus:outline-none dark:from-indigo-600 dark:to-purple-600 dark:hover:from-indigo-700 dark:hover:to-purple-700 dark:focus:ring-indigo-500 dark:focus:ring-offset-slate-900"
                    >
                        <span>Criar conta</span>
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>

                    <div class="text-center">
                        <p class="text-sm text-gray-600 dark:text-slate-400">
                            Já tem uma conta?
                            <a
                                href="{{ route('login') }}"
                                class="font-semibold text-violet-600 hover:text-violet-700 dark:text-indigo-400 dark:hover:text-indigo-300"
                            >
                                Fazer login
                            </a>
                        </p>
                    </div>
                </form>
            </div>

            <div class="mt-6 text-center">
                <p class="text-xs text-gray-500 dark:text-slate-500">
                    Ao criar uma conta, você concorda com nossos
                    <a href="#" class="text-violet-600 hover:underline dark:text-indigo-400">Termos de Serviço</a>
                    e
                    <a href="#" class="text-violet-600 hover:underline dark:text-indigo-400">Política de Privacidade</a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>

<?php
