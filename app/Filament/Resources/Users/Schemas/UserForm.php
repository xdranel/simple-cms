<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->unique(table: 'users', ignoreRecord: true)
                    ->maxLength(255)
                    ->validationMessages([
                        'required' => 'The name is required.',
                        'unique' => 'The name has already been taken.',
                        'max' => 'The name must not be greater than 255 characters.',
                    ]),

                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required()
                    ->unique(table: 'users', ignoreRecord: true)
                    ->maxLength(255)
                    ->validationMessages([
                        'required' => 'The email is required.',
                        'unique' => 'The email has already been taken.',
                        'max' => 'The email must not be greater than 255 characters.',
                    ]),

                TextInput::make('password')
                    ->password()
                    ->revealable()
                    ->minLength(8)
                    ->required(fn(string $operation): bool => $operation === 'create')
                    ->saved(fn(?string $state): bool => filled($state))
                    ->validationMessages([
                        'required' => 'The password is required.',
                        'min' => 'The password must be at least 8 characters.',
                    ]),

                Select::make('role')
                    ->options([
                        'admin' => 'Admin',
                        'author' => 'Author',
                    ])
                    ->required()
                    ->default('author')
                    ->validationMessages([
                        'required' => 'The role is required.',
                    ]),

                Textarea::make('bio')
                    ->rows(4)
                    ->columnSpanFull(),

                FileUpload::make('avatar')
                    ->avatar()
                    ->image()
                    ->disk('public')
                    ->directory('authors/avatars')
                    ->maxSize(2048)
                    ->default(null),
            ]);
    }
}
