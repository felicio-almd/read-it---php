<?php

declare(strict_types=1);

?>

<x-layouts.auth>
    <main class="min-h-screen bg-gray-50 dark:bg-slate-950">
        <x-navbar />

        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <div class="flex gap-6">
                <!-- Conteúdo Principal -->
                <div class="flex-1">
                    <div
                        class="mb-6 overflow-hidden rounded-2xl bg-white shadow-sm dark:bg-slate-900 dark:shadow-slate-950/50"
                    >
                        <div
                            class="h-48 bg-gradient-to-br from-gray-800 to-gray-900 dark:from-slate-800 dark:to-slate-950"
                            @if ($subreddit->banner_image)
                                style="background-image: url('{{ asset("storage/" . $subreddit->banner_image) }}');
                                                                                            background-size: cover;
                                                                                            background-position: center;"
                            @endif
                        ></div>

                        <div class="p-6">
                            <div
                                class="flex items-start justify-between max-md:flex-col max-md:items-center max-md:gap-6"
                            >
                                <div class="flex items-start gap-4 max-md:flex-col">
                                    {{-- Ícone --}}
                                    <div class="-mt-16 flex-shrink-0">
                                        <div class="rounded-2xl bg-white p-1 shadow-lg dark:bg-slate-800">
                                            <img
                                                src="{{ asset("storage/" . $subreddit->icon_image) ?? "https://api.dicebear.com/8.x/bottts/svg?seed=" . $subreddit->slug }}"
                                                alt="Ícone de {{ $subreddit->name }}"
                                                class="h-20 w-20 rounded-xl"
                                            />
                                        </div>
                                    </div>

                                    <div class="pt-2">
                                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                                            r/ {{ $subreddit->name }}
                                        </h1>
                                        <p class="mt-2 text-sm text-gray-600 dark:text-slate-400">
                                            {{ $subreddit->description ?? "Lorem ipsum dolor sit amet, consectetur adipiscing elit. In porttitor pretium..." }}
                                        </p>

                                        <div
                                            class="mt-4 flex items-center gap-6 text-sm text-gray-600 dark:text-slate-400"
                                        >
                                            <div class="flex items-center gap-1.5">
                                                <x-lucide-users class="h-4 w-4" />
                                                <span class="font-medium">
                                                    {{ number_format($subreddit->member_count) }} membros
                                                </span>
                                            </div>
                                            <div class="flex items-center gap-1.5">
                                                <x-lucide-calendar class="h-4 w-4" />
                                                <span>Criado em {{ $subreddit->created_at->format("M, Y") }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex flex-shrink-0 gap-2 max-md:w-4/5 max-md:flex-col">
                                    @auth
                                        @if ($subreddit->isMember(auth()->user()))
                                            @if ($subreddit->created_by === auth()->id())
                                                {{-- Criador: só pode excluir --}}
                                                <form
                                                    action="{{ route("subreddits.destroy", $subreddit) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Tem certeza que deseja excluir esta comunidade?')"
                                                >
                                                    @csrf
                                                    @method("DELETE")
                                                    <button
                                                        type="submit"
                                                        class="h-11 rounded-xl bg-red-600 px-6 py-2.5 text-sm font-semibold text-white transition-all hover:bg-red-700 hover:shadow-md max-md:w-full dark:bg-red-600 dark:hover:bg-red-700"
                                                    >
                                                        Excluir
                                                    </button>
                                                </form>
                                            @else
                                                <form
                                                    action="{{ route("subreddits.leave", $subreddit) }}"
                                                    method="POST"
                                                >
                                                    @csrf
                                                    <button
                                                        type="submit"
                                                        class="h-11 rounded-xl bg-gray-100 px-6 py-2.5 text-sm font-semibold text-gray-700 transition-all hover:bg-gray-200 hover:shadow-md max-md:w-full dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700"
                                                    >
                                                        Sair
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            <form action="{{ route("subreddits.join", $subreddit) }}" method="POST">
                                                @csrf
                                                <button
                                                    type="submit"
                                                    class="h-11 rounded-xl bg-violet-600 px-6 py-2.5 text-sm font-semibold text-white transition-all hover:bg-violet-700 hover:shadow-md max-md:w-full dark:bg-indigo-600 dark:hover:bg-indigo-700"
                                                >
                                                    Entrar
                                                </button>
                                            </form>
                                        @endif
                                    @endauth

                                    @auth
                                        @if ($subreddit->canPost(auth()->user()))
                                            <div class="mb-6">
                                                <a
                                                    href="{{ route("posts.create", $subreddit->id) }}"
                                                    class="flex h-11 items-center justify-center gap-2 rounded-xl bg-violet-400 px-4 py-3 text-sm font-medium text-white shadow-sm transition-all hover:bg-violet-500 hover:shadow-md dark:bg-indigo-600 dark:hover:bg-indigo-700"
                                                >
                                                    <x-lucide-plus class="h-5 w-5" />
                                                    <span>Criar Novo Post</span>
                                                </a>
                                            </div>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl bg-white shadow-sm dark:bg-slate-900 dark:shadow-slate-950/50">
                        <div class="border-b border-gray-100 px-6 py-5 dark:border-slate-700">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                                Veja todos os posts da comunidade
                            </h2>
                        </div>

                        <div class="divide-y divide-gray-100 dark:divide-slate-700">
                            @forelse ($subreddit->posts as $post)
                                <div class="p-6">
                                    <x-post-card :post="$post" />
                                </div>
                            @empty
                                <div class="p-12 text-center">
                                    <div
                                        class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 dark:bg-slate-800"
                                    >
                                        <x-lucide-inbox class="h-8 w-8 text-gray-400 dark:text-slate-500" />
                                    </div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">Nenhum post ainda</p>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-slate-400">
                                        Esta comunidade ainda não tem posts. Seja o primeiro a postar!
                                    </p>
                                    @auth
                                        @if ($subreddit->canPost(auth()->user()))
                                            <a
                                                href="{{ route("posts.create", $subreddit->id) }}"
                                                class="mt-4 inline-flex items-center rounded-lg bg-violet-600 px-4 py-2 text-sm font-semibold text-white hover:bg-violet-700 dark:bg-indigo-600 dark:hover:bg-indigo-700"
                                            >
                                                Criar Primeiro Post
                                            </a>
                                        @endif
                                    @endauth
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layouts.auth>

<?php
