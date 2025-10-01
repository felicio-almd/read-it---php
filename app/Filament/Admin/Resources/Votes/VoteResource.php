<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Votes;

use App\Filament\Admin\Resources\Votes\Pages\ManageVotes;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Vote;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\MorphToSelect;
use Filament\Forms\Components\MorphToSelect\Type;
use Filament\Forms\Components\Select;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

final class VoteResource extends Resource
{
    protected static ?string $model = Vote::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHandThumbUp;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(null)
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                MorphToSelect::make('votable')
                    ->types([
                        Type::make(Post::class)
                            ->titleAttribute('title'),
                        Type::make(Comment::class)
                            ->titleAttribute('content'),
                    ]),
                Select::make('vote_type')
                    ->options([
                        'up' => 'upvote',
                        'down' => 'downvote',
                    ])
                    ->required(),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('ID'),
                TextEntry::make('user.name')
                    ->label('User'),
                TextEntry::make('votable_id'),
                TextEntry::make('votable_type'),
                TextEntry::make('vote_type'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Vote')
            ->columns([
                TextColumn::make('user.name')
                    ->searchable(),
                TextColumn::make('votable_id')
                    ->searchable(),
                TextColumn::make('votable_type')
                    ->searchable(),
                TextColumn::make('vote_type')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageVotes::route('/'),
        ];
    }
}
