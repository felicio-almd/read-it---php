<?php

declare(strict_types=1);

?>

<x-layouts.auth>
    <x-navbar />
    {{-- Banner do Subreddit --}}
    <header class="bg-white shadow">
        <div
            class="h-40 bg-gray-200"
            style="
                background-image: url('{{ $subreddit->banner_image }}');
                background-size: cover;
                background-position: center;
            "
        ></div>
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <div class="-mt-12 flex items-end">
                <img
                    src="{{ $subreddit->icon_image ?? 'https://api.dicebear.com/8.x/bottts/svg?seed=' . $subreddit->slug }}"
                    alt="Ícone"
                    class="h-24 w-24 rounded-full border-4 border-white bg-white"
                />
                <div class="ml-4">
                    <h1 class="text-3xl font-bold text-gray-900">{{ $subreddit->name }}</h1>
                    <p class="text-sm text-gray-500">r/{{ $subreddit->slug }}</p>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-between">
                <span class="text-sm text-gray-600">{{ $subreddit->member_count }} membros</span>

                {{-- Botões de Ação --}}
                @auth
                    @if ($subreddit->isMember(auth()->user()))
                        @if ($subreddit->created_by === auth()->id())
                            {{-- Criador: só pode excluir --}}
                            <form
                                action="{{ route('subreddits.destroy', $subreddit) }}"
                                method="POST"
                                onsubmit="return confirm('Tem certeza que deseja excluir esta comunidade?')"
                            >
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="rounded-full bg-red-600 px-4 py-1 text-sm font-semibold text-white hover:bg-red-700"
                                >
                                    Excluir
                                </button>
                            </form>
                        @else
                            {{-- Membro comum: pode sair --}}
                            <form action="{{ route('subreddits.leave', $subreddit) }}" method="POST">
                                @csrf
                                <button
                                    type="submit"
                                    class="rounded-full bg-gray-200 px-4 py-1 text-sm font-semibold text-gray-800 hover:bg-gray-300"
                                >
                                    Sair
                                </button>
                            </form>
                        @endif
                    @else
                        {{-- Não é membro: pode entrar --}}
                        <form action="{{ route('subreddits.join', $subreddit) }}" method="POST">
                            @csrf
                            <button
                                type="submit"
                                class="rounded-full bg-indigo-600 px-4 py-1 text-sm font-semibold text-white hover:bg-indigo-700"
                            >
                                Entrar
                            </button>
                        </form>
                    @endif
                @endauth
            </div>
        </div>
    </header>

    {{-- Feed de Posts --}}
    <div class="py-8">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            @auth
                @if ($subreddit->canPost(auth()->user()))
                    <div class="mb-4">
                        <a
                            href="{{ route('posts.create', $subreddit->id) }}"
                            class="block w-full rounded-md border border-gray-300 bg-white p-3 text-center text-sm font-medium text-gray-700 hover:bg-gray-50"
                        >
                            Criar Novo Post
                        </a>
                    </div>
                @endif
            @endauth

            {{-- Lista de Posts --}}
            <div class="space-y-4">
                @forelse ($subreddit->posts as $post)
                    <x-post-card :post="$post" class="mb-4" />
                @empty
                    <div class="rounded-lg bg-white p-6 text-center shadow">
                        <p class="text-gray-500">Esta comunidade ainda não tem posts.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.auth>

<?php
