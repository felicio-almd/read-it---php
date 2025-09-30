<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Subreddit;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class SearchController extends Controller
{
    /**
     * Exibe a página de resultados da pesquisa.
     */
    public function index(Request $request): View
    {
        $query = $request->input('query');
        $subreddits = collect();
        $posts = collect();

        if ($query) {
            $subreddits = Subreddit::query()
                ->where('name', 'like', '%'.$query.'%')
                ->orWhere('description', 'like', '%'.$query.'%')
                ->take(5)
                ->get();

            $posts = Post::query()
                ->where('title', 'like', '%'.$query.'%')
                ->orWhere('content', 'like', '%'.$query.'%')
                ->with(['user', 'subreddit'])
                ->latest()
                ->paginate(10);
        }

        return view('components.search-results', [
            'query' => $query,
            'subreddits' => $subreddits,
            'posts' => $posts,
        ]);
    }
}
