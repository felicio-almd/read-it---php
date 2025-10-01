<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Subreddits\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

final class SubredditInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('ID'),
                TextEntry::make('name'),
                TextEntry::make('slug'),
                TextEntry::make('description')
                    ->columnSpanFull(),
                TextEntry::make('rules')
                    ->placeholder('-')
                    ->columnSpanFull(),
                ImageEntry::make('banner_image')
                    ->placeholder('-'),
                ImageEntry::make('icon_image')
                    ->placeholder('-'),
                TextEntry::make('member_count')
                    ->numeric(),
                TextEntry::make('post_count')
                    ->numeric(),
                TextEntry::make('created_by'),
                IconEntry::make('is_active')
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
