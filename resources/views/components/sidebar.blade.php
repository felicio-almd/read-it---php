<?php

declare(strict_types=1);

?>
<aside class="w-80 flex-shrink-0">
    <div class="sticky top-20 space-y-4">
        <div class="rounded-lg bg-white p-4 shadow">
            <h2 class="mb-4 text-lg font-bold">Bem-vindo ao read-it!</h2>
            <p class="mb-4 text-sm text-gray-600">
                Sua fonte de notícias e discussões. Crie posts, comente e participe de comunidades sobre seus tópicos
                favoritos.
            </p>
            @auth
                <!-- Botões para usuários logados -->
                <a
                    href="#"
                    class="mb-2 block w-full rounded-full bg-indigo-600 px-4 py-2 text-center font-bold text-white hover:bg-indigo-700"
                >
                    Criar Post
                </a>
                <a
                    href="#"
                    class="block w-full rounded-full bg-gray-200 px-4 py-2 text-center font-bold text-gray-800 hover:bg-gray-300"
                >
                    Criar Comunidade
                </a>
            @endauth
        </div>

        <!-- Card de Comunidades Populares -->
        <div class="rounded-lg bg-white p-4 shadow">
            <h3 class="mb-3 font-bold">Comunidades Populares</h3>
            <ul>
                @forelse ($topSubreddits as $subreddit)
                    <li class="flex items-center space-x-3 rounded-md p-2 hover:bg-gray-100">
                        <img
                            src="{{ $subreddit->icon_image ?? 'https://api.dicebear.com/8.x/bottts/svg?seed=' . $subreddit->slug }}"
                            alt="Icone"
                            class="h-8 w-8 rounded-full bg-gray-200"
                        />
                        <div>
                            <a href="#" class="text-sm font-bold hover:underline">r/{{ $subreddit->name }}</a>
                            <p class="text-xs text-gray-500">{{ $subreddit->member_count }} membros</p>
                        </div>
                    </li>
                @empty
                    <li class="text-sm text-gray-500">Nenhuma comunidade encontrada.</li>
                @endforelse
            </ul>
        </div>

        <!--Footer-->
        <div class="rounded-lg bg-white p-4 text-xs text-gray-500 shadow">
            <div class="flex flex-wrap gap-x-4 gap-y-2">
                <a href="#" class="hover:underline">Ajuda</a>
                <a href="#" class="hover:underline">Sobre</a>
                <a href="#" class="hover:underline">Carreiras</a>
                <a href="#" class="hover:underline">Privacidade</a>
                <a href="#" class="hover:underline">Termos</a>
            </div>
            <p class="mt-4">read-it Inc. © {{ date('Y') }}. All rights reserved.</p>
        </div>
    </div>
</aside>
<?php 
