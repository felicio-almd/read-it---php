<?php

declare(strict_types=1);

namespace App\View\Components;

use App\Models\Subreddit;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

final class Sidebar extends Component
{
    public Collection $topSubreddits;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->topSubreddits = Subreddit::query()
            ->orderBy('member_count', 'desc')
            ->take(5)
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.sidebar');
    }
}
