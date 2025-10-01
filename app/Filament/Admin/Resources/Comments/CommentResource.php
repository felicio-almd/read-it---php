<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Comments;

use App\Filament\Admin\Resources\Comments\Pages\CreateComment;
use App\Filament\Admin\Resources\Comments\Pages\EditComment;
use App\Filament\Admin\Resources\Comments\Pages\ListComments;
use App\Filament\Admin\Resources\Comments\Pages\ViewComment;
use App\Filament\Admin\Resources\Comments\RelationManagers\VotesRelationManager;
use App\Filament\Admin\Resources\Comments\Schemas\CommentForm;
use App\Filament\Admin\Resources\Comments\Schemas\CommentInfolist;
use App\Filament\Admin\Resources\Comments\Tables\CommentsTable;
use App\Models\Comment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

final class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return CommentForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CommentInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CommentsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            VotesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListComments::route('/'),
            'create' => CreateComment::route('/create'),
            'view' => ViewComment::route('/{record}'),
            'edit' => EditComment::route('/{record}/edit'),
        ];
    }
}
