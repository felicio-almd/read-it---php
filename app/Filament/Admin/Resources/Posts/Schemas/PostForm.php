<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Posts\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

final class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                Textarea::make('content')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('content_type')
                    ->required()
                    ->default('text'),
                TextInput::make('url')
                    ->url(),
                FileUpload::make('image_path')
                    ->image(),
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Select::make('subreddit_id')
                    ->relationship('subreddit', 'name')
                    ->required(),
                Toggle::make('is_pinned')
                    ->required(),
                Toggle::make('is_locked')
                    ->required(),
            ]);
    }
}
