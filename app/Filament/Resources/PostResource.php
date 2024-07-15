<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Filament\Resources\PostResource\RelationManagers\AuthorRelationManager;
use App\Filament\Resources\PostResource\RelationManagers\CommentsRelationManager;
use App\Models\Categori;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\IconPosition;
use Filament\Tables;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Posts...(troquei o nome no resource)';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Tabs::make('Create New Post')->tabs([
                    Tab::make('Tab1')
                    ->icon('heroicon-m-inbox')
                    ->iconPosition(IconPosition::After)
                    ->badge('hi')
                    ->schema([
                        TextInput::make('title')->rules('max:250')->required(),
                        TextInput::make('slug')->required(),
                        Select::make('categori_id')
                            ->label('category')
                            ->relationship('categori', 'name')
                            ->searchable()
                            ->required(),
                        ColorPicker::make('color')->required(),
                    ]), 
                    Tab::make('Content')->schema([
                        MarkdownEditor::make('content')
                            ->required()
                            ->columnSpanFull(),
                    ]),
                    Tab::make('Meta')->schema([
                        FileUpload::make('thumbnail')
                            ->disk('public')->directory('thumbnails'), 
                        TagsInput::make('tags')->required(),
                        Checkbox::make('published')->required(),
                    ]),
                ])->columnSpanFull()->activeTab(3)->persistTabInQueryString(),
            ])->columns([3]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail')
                    ->toggleable(),
                ColorColumn::make('color')
                    ->toggleable(),
                TextColumn::make('title')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('slug')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('categori.name')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('tags')
                    ->toggleable(),
                CheckboxColumn::make('published')
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Published on')
                    ->sortable()
                    ->date()
                    ->searchable()
                    ->toggleable(),
            ])
            ->filters([
                // Filter::make('Published Posts')->query(
                //     function (Builder $query): Builder{
                //         return $query->where('published', true);
                //     }
                // ),
                TernaryFilter::make('published'),
                SelectFilter::make('categori_id')
                    ->label('Category')
                    ->relationship('categori', 'name')
                    ->searchable()
                    ->preload()
                    ->multiple()
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            AuthorRelationManager::class,
            CommentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
