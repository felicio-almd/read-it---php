<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Votes\Pages;

use App\Filament\Admin\Resources\Votes\VoteResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

final class ManageVotes extends ManageRecords
{
    protected static string $resource = VoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
