<?php

declare(strict_types=1);

?>

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div
                class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-r from-violet-600 to-purple-600 dark:from-indigo-600 dark:to-purple-600"
            >
                <x-lucide-user class="h-6 w-6 text-white" />
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ __('Profile') }}
                </h2>
                <p class="text-sm text-gray-500 dark:text-slate-400">Gerencie suas informações pessoais e segurança</p>
            </div>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gray-50 py-8 dark:bg-slate-950">
        <div class="mx-auto max-w-5xl space-y-6 px-4 sm:px-6 lg:px-8">
            <!-- Card 1 - Informações do Perfil -->
            <div
                class="overflow-hidden rounded-2xl bg-white shadow-sm transition-shadow hover:shadow-md dark:bg-slate-900 dark:shadow-slate-950/50"
            >
                <div
                    class="border-b border-gray-100 bg-gradient-to-r from-violet-50 to-purple-50 px-6 py-4 dark:border-slate-700 dark:from-indigo-900/20 dark:to-purple-900/20"
                >
                    <div class="flex items-center gap-3">
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-lg bg-violet-500 dark:bg-indigo-600"
                        >
                            <x-lucide-user-circle class="h-5 w-5 text-white" />
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Informações do Perfil</h3>
                            <p class="text-xs text-gray-600 dark:text-slate-400">Atualize seu nome e email</p>
                        </div>
                    </div>
                </div>
                <div class="p-6 sm:p-8">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <!-- Card 2 - Atualizar Senha -->
            <div
                class="overflow-hidden rounded-2xl bg-white shadow-sm transition-shadow hover:shadow-md dark:bg-slate-900 dark:shadow-slate-950/50"
            >
                <div
                    class="border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 dark:border-slate-700 dark:from-blue-900/20 dark:to-indigo-900/20"
                >
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-500 dark:bg-blue-600">
                            <x-lucide-lock class="h-5 w-5 text-white" />
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Segurança da Conta</h3>
                            <p class="text-xs text-gray-600 dark:text-slate-400">
                                Altere sua senha regularmente para manter sua conta segura
                            </p>
                        </div>
                    </div>
                </div>
                <div class="p-6 sm:p-8">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <!-- Card 3 - Deletar Conta -->
            <div
                class="overflow-hidden rounded-2xl bg-white shadow-sm transition-shadow hover:shadow-md dark:bg-slate-900 dark:shadow-slate-950/50"
            >
                <div
                    class="border-b border-gray-100 bg-gradient-to-r from-red-50 to-orange-50 px-6 py-4 dark:border-slate-700 dark:from-red-900/20 dark:to-orange-900/20"
                >
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-red-500 dark:bg-red-600">
                            <x-lucide-alert-triangle class="h-5 w-5 text-white" />
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Zona de Perigo</h3>
                            <p class="text-xs text-gray-600 dark:text-slate-400">
                                Exclua permanentemente sua conta e todos os seus dados
                            </p>
                        </div>
                    </div>
                </div>
                <div class="p-6 sm:p-8">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>

            <!-- Footer Info -->
            <div class="rounded-lg bg-blue-50 p-4 dark:bg-blue-900/20">
                <div class="flex items-start gap-3">
                    <div
                        class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-blue-500 dark:bg-blue-600"
                    >
                        <x-lucide-info class="h-4 w-4 text-white" />
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-blue-900 dark:text-blue-300">Dica de Segurança</p>
                        <p class="mt-1 text-xs text-blue-700 dark:text-blue-400">
                            Use uma senha forte com pelo menos 8 caracteres, incluindo letras maiúsculas, minúsculas,
                            números e símbolos.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<?php
