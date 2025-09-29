<?php

declare(strict_types=1);

?>

<x-layouts.guest>
    <main class="mx-auto">
        <div class="flex w-full gap-10 px-4 py-10 sm:px-6 lg:px-8">
            <x-sidebar />

            <x-feed>
                {{-- Mensagens de feedback --}}
                @if (session('success'))
                    <div class="mb-4 rounded-lg bg-green-100 p-4 text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 rounded-lg bg-red-100 p-4 text-red-700">
                        {{ session('error') }}
                    </div>
                @endif

                @forelse ($posts as $post)
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

                            <a href="#" class="rounded p-2 hover:bg-gray-200">
                                💬 {{ $post->comment_count }} Comentários
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="rounded-lg bg-white p-4 text-center shadow">
                        <p class="text-gray-500">Ainda não há posts para mostrar. Seja o primeiro!</p>
                    </div>
                @endforelse

                <div class="mt-4">
                    {{ $posts->links() }}
                </div>
            </x-feed>
        </div>
    </main>
</x-layouts.guest>

<?php
