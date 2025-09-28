<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Posts\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

final class PostInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('ID'),
                TextEntry::make('title'),
                TextEntry::make('content')
                    ->columnSpanFull(),
                TextEntry::make('content_type'),
                TextEntry::make('url')
                    ->placeholder('-'),
                ImageEntry::make('image_path')
                    ->placeholder('-'),
                TextEntry::make('user.name')
                    ->label('User'),
                TextEntry::make('subreddit.name')
                    ->label('Subreddit'),
                TextEntry::make('upvotes')
                    ->numeric(),
                TextEntry::make('downvotes')
                    ->numeric(),
                TextEntry::make('score')
                    ->numeric(),
                TextEntry::make('comment_count')
                    ->numeric(),
                IconEntry::make('is_pinned')
                    ->boolean(),
                IconEntry::make('is_locked')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
