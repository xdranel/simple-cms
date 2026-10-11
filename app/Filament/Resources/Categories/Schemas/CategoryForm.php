<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->unique(table: 'categories', ignoreRecord: true)
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
                        'required' => 'Category name is required.',
                        'unique' => 'This category name already exists.',
                    ]),

                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(table: 'categories', ignoreRecord: true)
                    ->validationMessages([
                        'required' => 'Slug is required.',
                        'unique' => 'This slug is already taken.',
                    ]),

                TextArea::make('description')
                    ->rows(4)
                    ->columnSpanFull(),
            ]);
    }
}
