<?php

declare(strict_types=1);

?>

<x-guest-layout>
    <div
        class="flex min-h-screen w-full items-center justify-center bg-gradient-to-br from-violet-50 via-purple-50 to-pink-50 px-4 py-12 sm:px-6 lg:px-8"
    >
        <div class="w-full max-w-md">
            <div class="mb-8 text-center">
                <div
                    class="mb-4 inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-violet-600 to-purple-600 shadow-lg"
                >
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"
                        />
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-900">Bem-vindo de volta!</h2>
                <p class="mt-2 text-sm text-gray-600">Entre para continuar no READ IT</p>
            </div>

            <div class="rounded-2xl bg-white p-8 shadow-xl">
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-900">Email</label>
                        <div class="relative mt-2">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg
                                    class="h-5 w-5 text-gray-400"
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
                                autofocus
                                autocomplete="username"
                                class="block w-full rounded-xl border-gray-300 py-3 pr-3 pl-10 text-gray-900 placeholder-gray-400 focus:border-violet-500 focus:ring-violet-500 sm:text-sm"
                                placeholder="seu@email.com"
                            />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-900">Senha</label>
                        <div class="relative mt-2">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg
                                    class="h-5 w-5 text-gray-400"
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
                                autocomplete="current-password"
                                class="block w-full rounded-xl border-gray-300 py-3 pr-3 pl-10 text-gray-900 placeholder-gray-400 focus:border-violet-500 focus:ring-violet-500 sm:text-sm"
                                placeholder="••••••••"
                            />
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <button
                        type="submit"
                        class="flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-violet-600 to-purple-600 px-4 py-3 text-sm font-semibold text-white shadow-lg transition-all hover:from-violet-700 hover:to-purple-700 focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 focus:outline-none"
                    >
                        <span>Entrar</span>
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6"
                            />
                        </svg>
                    </button>

                    <div class="text-center">
                        <p class="text-sm text-gray-600">
                            Não tem uma conta?
                            <a
                                href="{{ route('register') }}"
                                class="font-semibold text-violet-600 hover:text-violet-700"
                            >
                                Criar conta
                            </a>
                        </p>
                    </div>
                </form>
            </div>

            <div class="mt-6 text-center">
                <p class="text-xs text-gray-500">
                    Ao entrar, você concorda com nossos
                    <a href="#" class="text-violet-600 hover:underline">Termos de Serviço</a>
                    e
                    <a href="#" class="text-violet-600 hover:underline">Política de Privacidade</a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>

<?php
