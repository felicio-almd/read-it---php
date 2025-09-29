<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Subreddits;

use App\Filament\Admin\Resources\Subreddits\Pages\CreateSubreddit;
use App\Filament\Admin\Resources\Subreddits\Pages\EditSubreddit;
use App\Filament\Admin\Resources\Subreddits\Pages\ListSubreddits;
use App\Filament\Admin\Resources\Subreddits\Pages\ViewSubreddit;
use App\Filament\Admin\Resources\Subreddits\Schemas\SubredditForm;
use App\Filament\Admin\Resources\Subreddits\Schemas\SubredditInfolist;
use App\Filament\Admin\Resources\Subreddits\Tables\SubredditsTable;
use App\Models\Subreddit;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

final class SubredditResource extends Resource
{
    protected static ?string $model = Subreddit::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHashtag;

    // protected static ?string $recordTitleAttribute = 'Subreddit';

    public static function form(Schema $schema): Schema
    {
        return SubredditForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SubredditInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SubredditsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSubreddits::route('/'),
            'create' => CreateSubreddit::route('/create'),
            'view' => ViewSubreddit::route('/{record}'),
            'edit' => EditSubreddit::route('/{record}/edit'),
        ];
    }
}
