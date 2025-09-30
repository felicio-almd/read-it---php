<?php

declare(strict_types=1);

?>
<x-layouts.auth>
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
                        <form action="{{ route('subreddits.leave', $subreddit) }}" method="POST">
                            @csrf
                            <button
                                type="submit"
                                class="rounded-full bg-gray-200 px-4 py-1 text-sm font-semibold text-gray-800 hover:bg-gray-300"
                            >
                                Sair
                            </button>
                        </form>
                    @else
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
                            href="#"
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
                    <article class="mb-4 rounded-lg bg-white p-4 shadow">
                        <div class="text-xs text-gray-500">
                            <a href="" class="font-bold text-gray-800 hover:underline">
                                r/{{ $post->subreddit->name }}
                            </a>
                            <span class="mx-1">•</span>
                            <span>
                                Postado por
                                <a href="#" class="hover:underline">u/{{ $post->user->username }}</a>
                            </span>
                            <span>{{ $post->created_at->diffForHumans() }}</span>
                        </div>

                        <h2 class="mt-2 text-xl font-bold">
                            <a href="{{ route('post.show', $post->id) }}">{{ $post->title }}</a>
                        </h2>

                        <p class="mt-2 text-gray-700">
                            {{ Str::limit($post->content, 200) }}
                        </p>

                        <div
                            class="mt-6 flex items-center space-x-4 border-t border-gray-200 pt-4 text-sm font-bold text-gray-500"
                        >
                            <div class="flex items-center space-x-2">
                                @php
                                    $userVote = $post->getCurrentUserVote();
                                @endphp

                                {{-- Botão de Upvote --}}
                                @auth
                                    <form action="{{ route('post.like', $post->id) }}" method="POST">
                                        @csrf
                                        <button
                                            type="submit"
                                            class="{{ $userVote === 'up' ? 'bg-orange-100 text-orange-600' : 'hover:bg-gray-100' }} flex items-center rounded-md p-2 transition-colors"
                                            title="{{ $userVote === 'up' ? 'Remover upvote' : 'Dar upvote' }}"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5"
                                                viewBox="0 0 20 20"
                                                fill="currentColor"
                                            >
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M10 3a1 1 0 01.707.293l5 5a1 1 0 01-1.414 1.414L11 6.414V16a1 1 0 11-2 0V6.414L5.707 9.707a1 1 0 01-1.414-1.414l5-5A1 1 0 0110 3z"
                                                    clip-rule="evenodd"
                                                />
                                            </svg>
                                        </button>
                                    </form>
                                @else
                                    <button
                                        onclick="alert('Você precisa estar logado para votar')"
                                        class="flex items-center rounded-md p-2 transition-colors hover:bg-gray-100"
                                        title="Faça login para votar"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5"
                                            viewBox="0 0 20 20"
                                            fill="currentColor"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M10 3a1 1 0 01.707.293l5 5a1 1 0 01-1.414 1.414L11 6.414V16a1 1 0 11-2 0V6.414L5.707 9.707a1 1 0 01-1.414-1.414l5-5A1 1 0 0110 3z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                    </button>
                                @endauth

                                {{-- Contador de votos --}}
                                <span
                                    class="{{ $post->score > 0 ? 'text-orange-600' : ($post->score < 0 ? 'text-indigo-600' : 'text-gray-600') }} min-w-[3rem] text-center font-bold"
                                >
                                    {{ $post->score }}
                                </span>

                                {{-- Botão de Downvote --}}
                                @auth
                                    <form action="{{ route('post.deslike', $post->id) }}" method="POST">
                                        @csrf
                                        <button
                                            type="submit"
                                            class="{{ $userVote === 'down' ? 'bg-indigo-100 text-indigo-600' : 'hover:bg-gray-100' }} flex items-center rounded-md p-2 transition-colors"
                                            title="{{ $userVote === 'down' ? 'Remover downvote' : 'Dar downvote' }}"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5"
                                                viewBox="0 0 20 20"
                                                fill="currentColor"
                                            >
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M10 17a1 1 0 00.707-.293l5-5a1 1 0 00-1.414-1.414L11 13.586V4a1 1 0 10-2 0v9.586L5.707 10.293a1 1 0 00-1.414 1.414l5 5A1 1 0 0010 17z"
                                                    clip-rule="evenodd"
                                                />
                                            </svg>
                                        </button>
                                    </form>
                                @else
                                    <button
                                        class="flex items-center rounded-md p-2 transition-colors hover:bg-gray-100"
                                        title="Faça login para votar"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5"
                                            viewBox="0 0 20 20"
                                            fill="currentColor"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M10 17a1 1 0 00.707-.293l5-5a1 1 0 00-1.414-1.414L11 13.586V4a1 1 0 10-2 0v9.586L5.707 10.293a1 1 0 00-1.414 1.414l5 5A1 1 0 0010 17z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                    </button>
                                @endauth
                            </div>

                            <a href="#" class="rounded p-2 hover:bg-gray-200">💬 {{ $post->comment_count }}</a>
                            <a href="#" class="rounded p-2 hover:bg-gray-200">Responder</a>
                        </div>
                    </article>
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
