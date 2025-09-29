<?php

declare(strict_types=1);

?>
<x-layouts.auth>
    <div class="space-y-8">
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
                        <a href="#" class="font-bold text-gray-900 hover:underline">/{{ $post->subreddit->name }}</a>
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

                {{-- Título do Post --}}
                <h1 class="mt-4 text-3xl leading-tight font-bold text-gray-900">
                    {{ $post->title }}
                </h1>
            </div>

            {{-- Imagem do Post (se existir) --}}
            @if ($post->image_path)
                <img src="{{ $post->image_path }}" alt="{{ $post->title }}" class="w-full object-cover" />
            @endif

            {{-- Conteúdo do Post --}}
            <div class="prose max-w-none p-6 leading-relaxed text-gray-700 sm:p-8">
                {!! Str::markdown($post->content) !!}
            </div>
        </article>

        {{-- Formulário para Adicionar Comentário --}}
        <div class="rounded-lg bg-white p-6 shadow-md sm:p-8">
            <form action="#" method="POST">
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
                        class="rounded-lg bg-indigo-600 px-6 py-2 font-bold text-white transition-colors hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none"
                    >
                        Responder
                    </button>
                </div>
            </form>
        </div>

        {{-- Seção de Comentários Existentes --}}
        <div class="space-y-4">
            <h2 class="text-xl font-bold text-gray-800">Todas as respostas</h2>

            @forelse ($post->comments as $comment)
                <div class="rounded-lg bg-white p-4 shadow-md" style="margin-left: {{ $comment->depth * 1.5 }}rem">
                    <div class="flex items-center space-x-3 text-xs text-gray-500">
                        <img
                            src="{{ $comment->user?->getFilamentAvatarUrl() ?? 'https://api.dicebear.com/8.x/bottts/svg?seed=' . $comment->user?->username }}"
                            alt="Avatar do usuário"
                            class="h-6 w-6 rounded-full bg-gray-200"
                        />
                        <a href="#" class="font-bold hover:underline">
                            {{ $comment->user?->username ?? '[usuário deletado]' }}
                        </a>
                        <span class="mx-1">•</span>
                        <span>{{ $comment->created_at->diffForHumans() }}</span>
                    </div>

                    <p class="mt-2 text-gray-800">{{ $comment->content }}</p>

                    {{-- Botão de Responder (lógica a ser implementada) --}}
                    <div class="mt-2">
                        <button class="text-xs font-bold text-gray-500 hover:text-indigo-600">Responder</button>
                    </div>
                </div>
            @empty
                <div class="rounded-lg bg-white p-6 text-center shadow-md">
                    <p class="text-gray-500">Nenhum comentário ainda. Seja o primeiro a responder!</p>
                </div>
            @endforelse
        </div>
    </div>
</x-layouts.auth>
<?php 
