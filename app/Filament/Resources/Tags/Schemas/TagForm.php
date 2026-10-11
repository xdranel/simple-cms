<?php

namespace App\Filament\Resources\Tags\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class TagForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->unique(table: 'tags', ignoreRecord: true)
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(
                        function (Get $get, Set $set, ?string $old, ?string $state): void {
                            if (filled($get('slug')) && $get('slug') !== Str::slug($old ?? '')) {
                                return;
                            }

                            $set('slug', Str::slug($state ?? ''));
                        }
                    )
                    ->validationMessages([
                        'required' => 'Tag name is required.',
                        'unique' => 'This tag name already exists.',
                    ]),

                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(table: 'tags', ignoreRecord: true)
                    ->validationMessages([
                        'required' => 'Slug is required.',
                        'unique' => 'This slug is already taken.',
                    ]),
            ]);
    }
}
