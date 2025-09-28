<?php

declare(strict_types=1);

?>

<x-layouts.guest>
    <main class="mx-auto">
        <div class="flex">
            <x-sidebar />

            <x-feed>
                <!-- exibir posts  -->
                @forelse ($posts as $post)
                    <article class="mb-4 rounded-lg bg-white p-4 shadow">
                        <div class="text-xs text-gray-500">
                            <a href="#" class="font-bold text-gray-800 hover:underline">
                                r/{{ $post->subreddit->name }}
                            </a>
                            <span class="mx-1">•</span>
                            <span>
                                Postado por
                                <a href="#" class="hover:underline">u/{{ $post->user->username }}</a>
                            </span>
                            <span>{{ $post->created_at->diffForHumans() }}</span>
                        </div>

                        <!-- Título -->
                        <h2 class="mt-2 text-xl font-bold">
                            <a href="#">{{ $post->title }}</a>
                        </h2>

                        <p class="mt-2 text-gray-700">
                            {{ Str::limit($post->content, 200) }}
                        </p>

                        <!-- Ações (Votos, Comentários)  -->
                        <div class="mt-4 text-sm font-bold text-gray-500">
                            <a href="#" class="rounded p-2 hover:bg-gray-200">⬆⬇ {{ $post->score }} Votos</a>
                            <a href="#" class="ml-4 rounded p-2 hover:bg-gray-200">
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
