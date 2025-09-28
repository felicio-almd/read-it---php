<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Users\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

final class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('username')
                    ->required(),
                FileUpload::make('avatar')
                    ->directory('user_avatars'),
                Textarea::make('bio')
                    ->columnSpanFull(),
                TextInput::make('karma')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('password')
                    ->password()
                    ->required(),
            ]);
    }
}
