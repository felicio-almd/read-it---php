<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Posts\Pages;

use App\Filament\Admin\Resources\Posts\PostResource;
use App\Traits\HasVotableActions;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

final class ViewPost extends ViewRecord
{
    use HasVotableActions;

    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            $this->getUpvoteAction(),
            $this->getDownvoteAction(),
            EditAction::make(),
        ];
    }
}
