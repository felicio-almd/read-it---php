<?php

declare(strict_types=1);

namespace App\View\Components;

use App\Models\Subreddit;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

final class Sidebar extends Component
{
    /**
     * @var Collection<int, Subreddit>
     */
    public Collection $subreddits;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        if (Auth::check()) {
            $this->subreddits = Auth::user()->subreddits()->get();
        } else {
            $this->subreddits = Subreddit::query()
                ->orderBy('member_count', 'desc')
                ->take(5)
                ->get();
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.sidebar');
    }
}
