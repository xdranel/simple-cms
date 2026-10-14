<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Models\Post;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(
                        function (Get $get, Set $set, ?string $old, ?string $state): void {
                            if (filled($get('slug')) && $get('slug') !== Str::slug($old ?? '')) {
                                return;
                            }
                            $set('slug', Str::slug($state ?? ''));
                        }
                    ),

                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(
                        table: 'posts',
                        ignoreRecord: true
                    )
                    ->validationMessages([
                        'required' => 'Slug is required.',
                        'unique' => 'This slug is already taken.',
                        'max' => 'Slug must be no more than 255 characters long.',
                    ]),

                Select::make('user_id')
                    ->required()
                    ->label('Author')
                    ->relationship(
                        name: 'author',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn($query) => $query->whereIn('role', ['admin', 'author'])
                    )
                    ->searchable()
                    ->preload()
                    ->default(fn() => auth()->id())
                    ->disabled(fn() => !auth()->user()->isAdmin())
                    ->dehydrated()
                    ->validationMessages([
                        'required' => 'Author is required.',
                    ]),

                Select::make('category_id')
                    ->required()
                    ->label('Category')
                    ->relationship(
                        name: 'category',
                        titleAttribute: 'name'
                    )
                    ->searchable()
                    ->preload()
                    ->validationMessages([
                        'required' => 'Category is required.',
                    ]),

                Select::make('tags')
                    ->label('Tags')
                    ->multiple()
                    ->relationship(
                        name: 'tags',
                        titleAttribute: 'name'
                    )
                    ->searchable()
                    ->preload(),

                Textarea::make('excerpt')
                    ->rows(4)
                    ->columnSpanFull(),

                RichEditor::make('content')
                    ->required()
                    ->columnSpanFull()
                    ->validationMessages([
                        'required' => 'Content is required.',
                    ]),

                Select::make('status')
                    ->required()
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                    ])
                    ->default('draft')
                    ->disabled(fn() => !auth()->user()->isAdmin())
                    ->dehydrated()
                    ->columnSpanFull()
                    ->validationMessages([
                        'required' => 'Status is required.',
                    ]),

                Section::make('Featured Content')
                    ->description('Manage post image and featured status.')
                    ->schema([
                        FileUpload::make('featured_image')
                            ->label('Featured Image')
                            ->image()
                            ->disk('public')
                            ->directory('posts/featured')
                            ->visibility('public')
                            ->maxSize(2048)
                            ->imageEditor()
                            ->columnSpanFull()
                            ->validationMessages([
                                'max' => 'Featured image must be no more than 2 MB.',
                            ]),

                        Toggle::make('is_featured')
                            ->label('Featured Post')
                            ->default(false)
                            ->disabled(fn() => !auth()->user()->isAdmin())
                            ->dehydrated(),

                        DateTimePicker::make('published_at')
                            ->label('Published At')
                            ->disabled()
                            ->dehydrated(false),
                    ])
                    ->collapsible()
                    ->collapsed(),

                Section::make('SEO Metadata')
                    ->description('Optional metadata for search engines.')
                    ->relationship(
                        name: 'seo'
                    )
                    ->schema([
                        TextInput::make('meta_title')
                            ->label('Meta Title')
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->validationMessages([
                                'max' => 'The meta title must not exceed 255 characters.',
                            ]),

                        Textarea::make('meta_description')
                            ->label('Meta Description')
                            ->rows(3)
                            ->columnSpanFull(),

                        TextInput::make('canonical_url')
                            ->label('Canonical URL')
                            ->url()
                            ->maxLength(2048)
                            ->columnSpanFull()
                            ->validationMessages([
                                'max' => 'The canonical URL must not exceed 2048 characters.',
                            ]),

                        FileUpload::make('og_image')
                            ->label('Open Graph Image')
                            ->image()
                            ->disk('public')
                            ->directory('posts/seo')
                            ->visibility('public')
                            ->maxSize(2048)
                            ->columnSpanFull()
                            ->validationMessages([
                                'max' => 'Open Graph Image must be no more than 2 MB'
                            ]),

                        Toggle::make('robots_index')
                            ->label('Allow Indexing')
                            ->default(true),

                        Toggle::make('robots_follow')
                            ->label('Follow Links')
                            ->default(true)
                    ])
                    ->columns()
                    ->collapsible()
                    ->collapsed(),

                Select::make('relatedPosts')
                    ->label('Related Posts')
                    ->multiple()
                    ->relationship(
                        name: 'relatedPosts',
                        titleAttribute: 'title',
                        modifyQueryUsing: function (Builder $query, ?Post $record) {
                            if ($record) {
                                $query->whereKeyNot($record->id);
                            }

                            return $query->where('status', 'published');
                        }
                    )
                    ->searchable()
                    ->preload()
                    ->helperText('Select published posts related to this post.')

            ]);
    }
}
