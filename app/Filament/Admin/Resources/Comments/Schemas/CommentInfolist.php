<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Comments\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

final class CommentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('ID'),
                TextEntry::make('content'),
                TextEntry::make('user.name')
                    ->label('User'),
                TextEntry::make('post.title')
                    ->label('Post'),
                TextEntry::make('parent.id')
                    ->label('Parent')
                    ->placeholder('-'),
                TextEntry::make('depth')
                    ->numeric(),
                TextEntry::make('path')
                    ->placeholder('-'),
                TextEntry::make('upvotes')
                    ->numeric(),
                TextEntry::make('downvotes')
                    ->numeric(),
                TextEntry::make('score')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
