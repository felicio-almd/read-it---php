<?php

declare(strict_types=1);

?>

@props([
    'post',
])

<article
    {{ $attributes->merge(['class' => 'bg-white rounded-lg shadow-md overflow-hidden dark:bg-slate-900 dark:shadow-slate-950/50']) }}
>
    <div class="p-4 sm:p-6">
        <div class="flex justify-between">
            <div class="flex items-center space-x-3 text-xs text-gray-500 dark:text-slate-400">
                <img
                    src="{{ $post->subreddit->icon_image ?? 'https://api.dicebear.com/8.x/bottts/svg?seed=' . $post->subreddit->slug }}"
                    alt="Ícone do Subreddit"
                    class="h-6 w-6 rounded-full bg-gray-200 dark:bg-slate-700"
                />
                <div>
                    <a
                        href="{{ route('subreddits.show', $post->subreddit) }}"
                        class="font-bold text-gray-800 hover:underline dark:text-indigo-400 dark:hover:text-indigo-300"
                    >
                        r/{{ $post->subreddit->name }}
                    </a>
                    <span class="mx-1">•</span>
                    <span>
                        Postado por
                        <a href="#" class="hover:underline dark:hover:text-slate-300">u/{{ $post->user->username }}</a>
                    </span>
                    <span>{{ $post->created_at->diffForHumans() }}</span>
                </div>
            </div>
        </div>

        <h2 class="mt-3 text-lg font-bold text-gray-900 dark:text-white">
            <a href="{{ route('post.show', $post) }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">
                {{ $post->title }}
            </a>
        </h2>

        <p class="mt-2 text-sm text-gray-700 dark:text-slate-300">
            {{ Str::limit($post->content, 250) }}
        </p>

        <div
            class="mt-4 flex items-center space-x-4 border-t border-gray-100 pt-3 text-sm font-bold text-gray-500 dark:border-slate-700 dark:text-slate-400"
        >
            <div class="flex items-center space-x-1">
                @php
                    $userVote = $post->getCurrentUserVote();
                @endphp

                @auth
                    <form action="{{ route('post.like', $post->id) }}" method="POST">
                        @csrf
                        <button
                            type="submit"
                            class="{{ $userVote === 'up' ? 'bg-indigo-100 text-indigo-600 dark:bg-indigo-900/50 dark:text-indigo-400' : 'hover:bg-gray-100 dark:hover:bg-slate-800' }} flex items-center rounded-md p-2 transition-colors"
                        >
                            <x-lucide-thumbs-up class="h-4 w-4" />
                        </button>
                    </form>

                    <form action="{{ route('post.deslike', $post->id) }}" method="POST">
                        @csrf
                        <button
                            type="submit"
                            class="{{ $userVote === 'down' ? 'bg-orange-100 text-orange-600 dark:bg-orange-900/50 dark:text-orange-400' : 'hover:bg-gray-100 dark:hover:bg-slate-800' }} flex items-center rounded-md p-2 transition-colors"
                        >
                            <x-lucide-thumbs-down class="h-4 w-4" />
                        </button>
                    </form>
                @else
                    <button class="flex items-center rounded-md p-2 hover:bg-gray-100 dark:hover:bg-slate-800" disabled>
                        <x-lucide-thumbs-up class="h-4 w-4" />
                    </button>
                    <span class="w-8 text-center text-xs dark:text-slate-300">{{ $post->score }}</span>
                    <button class="flex items-center rounded-md p-2 hover:bg-gray-100 dark:hover:bg-slate-800" disabled>
                        <x-lucide-thumbs-down class="h-4 w-4" />
                    </button>
                @endauth
            </div>

            <a
                href="{{ route('post.show', $post) }}#comments"
                class="flex items-center space-x-1 rounded-md p-2 hover:bg-gray-100 dark:text-slate-400 dark:hover:bg-slate-800"
            >
                <x-lucide-message-square class="h-4 w-4" />
                <span>{{ $post->comment_count }} Comentários</span>
            </a>
        </div>
    </div>
</article>

<?php
