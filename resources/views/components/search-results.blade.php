<?php

declare(strict_types=1);

?>
<x-layouts.auth>
    <div class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="rounded-lg bg-white p-6 shadow">
            <h1 class="mb-6 text-2xl font-bold text-gray-900">
                Resultados da pesquisa por:
                <span class="text-indigo-600">"{{ $query }}"</span>
            </h1>

            {{-- Resultados de Comunidades --}}
            @if ($subreddits->isNotEmpty())
                <div class="mb-8">
                    <h2 class="mb-4 border-b pb-2 text-lg font-semibold text-gray-800">Comunidades</h2>
                    <div class="space-y-4 pt-4">
                        @foreach ($subreddits as $subreddit)
                            <div class="flex items-center space-x-4 rounded-md p-3 hover:bg-gray-50">
                                <img
                                    src="{{ $subreddit->icon_image ?? 'https://api.dicebear.com/8.x/bottts/svg?seed=' . $subreddit->slug }}"
                                    alt="Ícone"
                                    class="h-12 w-12 rounded-full bg-gray-200"
                                />
                                <div>
                                    <a
                                        href="{{ route('subreddits.show', $subreddit) }}"
                                        class="text-lg font-bold hover:underline"
                                    >
                                        r/{{ $subreddit->name }}
                                    </a>
                                    <p class="text-sm text-gray-500">{{ $subreddit->member_count }} membros</p>
                                    <p class="mt-1 text-sm text-gray-600">
                                        {{ Str::limit($subreddit->description, 100) }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Resultados de Posts --}}
            <div class="mb-8">
                <h2 class="mb-4 border-b pb-2 text-lg font-semibold text-gray-800">Posts</h2>
                <div class="space-y-4 pt-4">
                    @forelse ($posts as $post)
                        {{-- Reutiliza o seu componente de card de post --}}
                        <x-post-card :post="$post" />
                    @empty
                        <p class="py-4 text-center text-gray-500">
                            Nenhum post encontrado para o termo "{{ $query }}".
                        </p>
                    @endforelse
                </div>
            </div>

            {{-- Links de Paginação para os Posts --}}
            <div class="mt-6">
                {{-- O appends() garante que o termo de pesquisa seja mantido ao mudar de página --}}
                {{ $posts->appends(['query' => $query])->links() }}
            </div>
        </div>
    </div>
</x-layouts.auth>
<?php 
