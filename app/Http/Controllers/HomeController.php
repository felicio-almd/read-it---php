<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use App\Models\Post;
use Illuminate\Http\Request;

final class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     * Este é o método mágico que estava faltando.
     */
    public function __invoke(Request $request): View|Factory
    {
        // Busca os posts no banco de dados
        $posts = Post::query()
            ->with(['subreddit', 'user']) // Eager Loading para evitar N+1 queries
            ->latest() // Ordena pelos mais recentes
            ->paginate(15); // Paginação

        // Retorna a view 'welcome' (ou o nome da sua view principal) e passa os posts para ela
        return view('welcome', [
            'posts' => $posts,
        ]);
    }
}
