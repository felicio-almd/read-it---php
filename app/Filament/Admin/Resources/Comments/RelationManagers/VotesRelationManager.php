<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Comments\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class VotesRelationManager extends RelationManager
{
    protected static string $relationship = 'votes';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name'),
                TextColumn::make('vote_type'),
            ]);
    }
}
