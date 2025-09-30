<?php

declare(strict_types=1);

?>

<x-layouts.auth>
    <div class="flex w-full gap-10 px-4 py-10 sm:px-6 lg:px-8">
        <x-sidebar />

        <div class="flex-grow space-y-8">
            {{-- Card Principal do Post --}}
            <article class="overflow-hidden rounded-lg bg-white shadow-md">
                <div class="p-6 sm:p-8">
                    {{-- Cabeçalho: Autor, Comunidade e Tempo --}}
                    <div class="flex items-center space-x-3 text-sm">
                        <img
                            src="{{ $post->user?->getFilamentAvatarUrl() ?? 'https://api.dicebear.com/8.x/bottts/svg?seed=' . $post->user?->username }}"
                            alt="Avatar do usuário"
                            class="h-8 w-8 rounded-full bg-gray-200"
                        />
                        <div>
                            <a href="#" class="font-bold text-gray-900 hover:underline">
                                /{{ $post->subreddit?->name ?? 'comunidade' }}
                            </a>
                            <span class="mx-1 text-gray-400">•</span>
                            <span class="text-gray-500">
                                Postado por
                                <a href="#" class="hover:underline">
                                    {{ $post->user?->username ?? '[usuário deletado]' }}
                                </a>
                                <span>{{ $post->created_at->diffForHumans() }}</span>
                            </span>
                        </div>
                    </div>

                    {{-- Título --}}
                    <h1 class="mt-4 text-2xl leading-tight font-bold text-gray-900">
                        {{ $post->title }}
                    </h1>

                    {{-- Conteúdo --}}
                    <div class="prose mt-4 max-w-none text-gray-700">
                        {!! nl2br(e($post->content)) !!}
                    </div>
                </div>
            </article>

            {{-- Formulário para Adicionar Comentário Raiz --}}
            @auth
                <div class="rounded-lg bg-white p-6 shadow-md sm:p-8">
                    <form action="{{ route('post.comments.add', $post) }}" method="POST">
                        @csrf
                        <textarea
                            name="content"
                            rows="4"
                            class="w-full rounded-lg border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Adicionar um comentário..."
                        ></textarea>
                        <div class="mt-4 flex justify-end">
                            <button
                                type="submit"
                                class="rounded-lg bg-indigo-600 px-6 py-2 font-bold text-white transition-colors hover:bg-indigo-700"
                            >
                                Responder
                            </button>
                        </div>
                    </form>
                </div>
            @endauth

            {{-- Lista de Comentários --}}
            <div class="rounded-lg bg-white p-6 shadow-md sm:p-8">
                <h3 class="mb-4 text-lg font-bold">Todas as respostas</h3>
                @forelse ($post->comments as $comment)
                    <div
                        x-data="{ openReply: false }"
                        class="{{ $loop->last ? '' : 'border-b border-gray-100' }} rounded p-3"
                        style="margin-left: {{ $comment->depth * 1.5 }}rem"
                    >
                        {{-- Conteúdo do Comentário --}}
                        <p class="text-xs text-gray-500">
                            <a href="#" class="font-bold hover:underline">
                                {{ $comment->user?->username ?? '[usuário deletado]' }}
                            </a>
                            <span class="mx-1">•</span>
                            <span>{{ $comment->created_at->diffForHumans() }}</span>
                        </p>
                        <p class="mt-2 text-gray-800">{{ $comment->content }}</p>

                        {{-- Botão de Responder --}}
                        @auth
                            <div class="mt-2 flex">
                                <button
                                    @click="openReply = !openReply"
                                    class="text-xs font-bold text-gray-500 hover:text-indigo-600"
                                >
                                    Responder
                                </button>
                                <div
                                    class="mt-6 flex items-center space-x-4 border-t border-gray-200 pt-4 text-sm font-bold text-gray-500"
                                >
                                    <div class="flex items-center space-x-2">
                                        @php
                                            $userVote = $comment->getCurrentUserVote();
                                        @endphp

                                        {{-- Botão de Upvote --}}
                                        @auth
                                            <form action="{{ route('comment.like', $comment->id) }}" method="POST">
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
                                            class="{{ $comment->score > 0 ? 'text-orange-600' : ($comment->score < 0 ? 'text-indigo-600' : 'text-gray-600') }} min-w-[3rem] text-center font-bold"
                                        >
                                            {{ $comment->score }}
                                        </span>

                                        {{-- Botão de Downvote --}}
                                        @auth
                                            <form action="{{ route('comment.deslike', $comment->id) }}" method="POST">
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
                                </div>
                            </div>
                        @endauth

                        {{-- Formulário de Resposta (escondido por padrão) --}}
                        <div x-show="openReply" x-cloak class="mt-3">
                            <form action="{{ route('post.comments.add', $post) }}" method="POST">
                                @csrf
                                <input type="hidden" name="parent_id" value="{{ $comment->id }}" />
                                <textarea
                                    name="content"
                                    rows="3"
                                    class="w-full rounded-lg border-gray-200 text-sm shadow-sm"
                                    placeholder="Escreva sua resposta..."
                                ></textarea>
                                <div class="mt-2 flex items-center justify-end space-x-3">
                                    <button
                                        @click="openReply = false"
                                        type="button"
                                        class="text-xs font-bold text-gray-500"
                                    >
                                        Cancelar
                                    </button>
                                    <button
                                        type="submit"
                                        class="rounded-full bg-indigo-600 px-4 py-1 text-xs font-bold text-white"
                                    >
                                        Enviar Resposta
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">Nenhum comentário ainda.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.auth>

<?php
