<?php

declare(strict_types=1);

?>

<x-layouts.auth>
    <main class="min-h-screen w-full bg-gray-50 dark:bg-slate-950">
        <x-navbar />

        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <div class="flex gap-6">
                <!-- Conteúdo Principal -->
                <div class="w-full flex-1">
                    <article
                        class="overflow-hidden rounded-2xl bg-white shadow-sm dark:bg-slate-900 dark:shadow-slate-950/50"
                    >
                        <div class="border-b border-gray-100 px-6 py-4 dark:border-slate-700">
                            <div class="flex items-center gap-3">
                                <img
                                    src="{{ $post->user?->getFilamentAvatarUrl() ?? 'https://api.dicebear.com/8.x/bottts/svg?seed=' . $post->user?->username }}"
                                    alt="Avatar"
                                    class="h-10 w-10 rounded-full ring-2 ring-gray-200 dark:ring-slate-700"
                                />
                                <div>
                                    <div class="flex items-center gap-2">
                                        <a
                                            href="#"
                                            class="text-sm font-semibold text-gray-900 hover:underline dark:text-white"
                                        >
                                            <span>@</span>
                                            {{ $post->user?->username ?? '[usuário deletado]' }}
                                        </a>
                                        <span class="text-sm text-gray-500 dark:text-slate-400">
                                            {{ $post->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <a href="#" class="text-xs text-violet-600 hover:underline dark:text-indigo-400">
                                        r/{{ $post->subreddit?->name ?? 'comunidade' }}
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="p-6">
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                                {{ $post->title }}
                            </h1>

                            @if ($post->image_path ?? false)
                                <div class="mt-4 max-h-64 overflow-hidden rounded-xl">
                                    <img
                                        src="{{ asset('storage/' . $post->image_path) }}"
                                        alt="Post image"
                                        class="h-auto w-full"
                                    />
                                </div>
                            @endif

                            <div
                                class="prose prose-sm dark:prose-invert mt-4 max-w-none text-gray-700 dark:text-slate-300"
                            >
                                {!! nl2br(e($post->content)) !!}
                            </div>
                        </div>
                    </article>

                    @auth
                        <div class="mt-6 rounded-2xl bg-white p-6 shadow-sm dark:bg-slate-900 dark:shadow-slate-950/50">
                            <form action="{{ route('post.comments.add', $post) }}" method="POST">
                                @csrf
                                <textarea
                                    name="content"
                                    rows="3"
                                    class="w-full rounded-xl border-gray-200 p-4 text-sm shadow-sm transition-colors focus:border-violet-500 focus:ring-violet-500 dark:border-slate-600 dark:bg-slate-800 dark:text-white dark:placeholder-slate-400 dark:focus:border-indigo-500 dark:focus:ring-indigo-500"
                                    placeholder="Adicionar um comentário..."
                                ></textarea>
                                <div class="mt-3 flex justify-end">
                                    <button
                                        type="submit"
                                        class="rounded-xl bg-violet-600 px-6 py-2 text-sm font-semibold text-white transition-all hover:bg-violet-700 hover:shadow-md dark:bg-indigo-600 dark:hover:bg-indigo-700"
                                    >
                                        Responder
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endauth

                    <div class="mt-6 rounded-2xl bg-white shadow-sm dark:bg-slate-900 dark:shadow-slate-950/50">
                        <div class="border-b border-gray-100 px-6 py-4 dark:border-slate-700">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Todas as respostas</h2>
                        </div>

                        <div class="divide-y divide-gray-100 dark:divide-slate-700">
                            @forelse ($post->comments as $comment)
                                <div
                                    x-data="{ openReply: false }"
                                    class="p-6 transition-colors hover:bg-gray-50 dark:hover:bg-slate-800/50"
                                    style="padding-left: {{ 1.5 + $comment->depth * 1.5 }}rem"
                                >
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-center gap-3">
                                            <img
                                                src="{{ $comment->user?->getFilamentAvatarUrl() ?? 'https://api.dicebear.com/8.x/bottts/svg?seed=' . $comment->user?->username }}"
                                                alt="Avatar"
                                                class="h-8 w-8 rounded-full ring-2 ring-gray-200 dark:ring-slate-700"
                                            />
                                            <div>
                                                <div class="flex items-center gap-2">
                                                    <a
                                                        href="#"
                                                        class="text-sm font-semibold text-gray-900 hover:underline dark:text-white"
                                                    >
                                                        {{ $comment->user?->username ?? '[usuário deletado]' }}
                                                    </a>
                                                    <span class="text-xs text-gray-500 dark:text-slate-400">
                                                        {{ $comment->created_at->diffForHumans() }}
                                                    </span>
                                                    @if ($comment->user_id === $post->user_id)
                                                        <span
                                                            class="rounded-md bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-700 dark:bg-blue-900/50 dark:text-blue-300"
                                                        >
                                                            Autor
                                                        </span>
                                                    @else
                                                        <span
                                                            class="rounded-md bg-green-100 px-2 py-0.5 text-xs font-medium text-green-500 dark:bg-green-900/50 dark:text-green-300"
                                                        >
                                                            Resposta
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <button
                                            class="text-gray-400 hover:text-gray-600 dark:text-slate-500 dark:hover:text-slate-300"
                                        >
                                            <x-lucide-more-horizontal class="h-5 w-5" />
                                        </button>
                                    </div>

                                    <div class="mt-2 ml-11">
                                        <p class="text-sm text-gray-700 dark:text-slate-300">
                                            {{ $comment->content }}
                                        </p>

                                        <div class="mt-3 flex items-center gap-4">
                                            @php
                                                $userVote = $comment->getCurrentUserVote();
                                            @endphp

                                            <div
                                                class="flex items-center gap-2 rounded-lg bg-gray-50 px-2 py-1 dark:bg-slate-800"
                                            >
                                                @auth
                                                    <form
                                                        action="{{ route('comment.like', $comment->id) }}"
                                                        method="POST"
                                                        class="inline"
                                                    >
                                                        @csrf
                                                        <button
                                                            type="submit"
                                                            class="{{ $userVote === 'up' ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500 hover:text-blue-600 dark:text-slate-400 dark:hover:text-blue-400' }} transition-colors"
                                                        >
                                                            <x-lucide-thumbs-up class="h-4 w-4" />
                                                        </button>
                                                    </form>
                                                @else
                                                    <button
                                                        class="text-gray-500 hover:text-blue-600 dark:text-slate-400 dark:hover:text-blue-400"
                                                    >
                                                        <x-lucide-thumbs-up class="h-4 w-4" />
                                                    </button>
                                                @endauth

                                                @auth
                                                    <form
                                                        action="{{ route('comment.deslike', $comment->id) }}"
                                                        method="POST"
                                                        class="inline"
                                                    >
                                                        @csrf
                                                        <button
                                                            type="submit"
                                                            class="{{ $userVote === 'down' ? 'text-orange-600 dark:text-orange-400' : 'text-gray-500 hover:text-orange-600 dark:text-slate-400 dark:hover:text-orange-400' }} transition-colors"
                                                        >
                                                            <x-lucide-thumbs-down class="h-4 w-4" />
                                                        </button>
                                                    </form>
                                                @else
                                                    <button
                                                        class="text-gray-500 hover:text-orange-600 dark:text-slate-400 dark:hover:text-orange-400"
                                                    >
                                                        <x-lucide-thumbs-down class="h-4 w-4" />
                                                    </button>
                                                @endauth
                                            </div>

                                            @auth
                                                <button
                                                    @click="openReply = !openReply"
                                                    class="flex items-center gap-1 text-xs font-semibold text-gray-600 hover:text-gray-900 dark:text-slate-400 dark:hover:text-slate-200"
                                                >
                                                    <x-lucide-message-square class="h-4 w-4" />
                                                    <span>Reply</span>
                                                </button>
                                            @endauth
                                        </div>

                                        <div x-show="openReply" x-cloak class="mt-4">
                                            <form action="{{ route('post.comments.add', $post) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="parent_id" value="{{ $comment->id }}" />
                                                <textarea
                                                    name="content"
                                                    rows="3"
                                                    class="w-full rounded-xl border-gray-200 p-4 text-sm shadow-sm transition-colors focus:border-violet-500 focus:ring-violet-500 dark:border-slate-600 dark:bg-slate-800 dark:text-white dark:placeholder-slate-400 dark:focus:border-indigo-500 dark:focus:ring-indigo-500"
                                                    placeholder="Escreva sua resposta..."
                                                ></textarea>
                                                <div class="mt-2 flex items-center justify-end gap-2">
                                                    <button
                                                        @click="openReply = false"
                                                        type="button"
                                                        class="rounded-lg px-4 py-1.5 text-xs font-semibold text-gray-600 hover:bg-gray-100 dark:text-slate-400 dark:hover:bg-slate-700"
                                                    >
                                                        Cancelar
                                                    </button>
                                                    <button
                                                        type="submit"
                                                        class="rounded-lg bg-violet-600 px-4 py-1.5 text-xs font-semibold text-white hover:bg-violet-700 dark:bg-indigo-600 dark:hover:bg-indigo-700"
                                                    >
                                                        Enviar Resposta
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="p-12 text-center">
                                    <div
                                        class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 dark:bg-slate-800"
                                    >
                                        <x-lucide-message-square class="h-8 w-8 text-gray-400 dark:text-slate-500" />
                                    </div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                        Nenhum comentário ainda
                                    </p>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-slate-400">
                                        Seja o primeiro a comentar neste post!
                                    </p>
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
