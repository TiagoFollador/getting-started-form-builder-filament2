<?php

namespace App\Filament\Resources\CategoriResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostsRelationManager extends RelationManager
{
    protected static string $relationship = 'posts';

    public function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make('Create a post')
                ->description("descricao, link na bio")
                ->schema([
                    TextInput::make('title')->rules('max:250')->required(),
                    TextInput::make('slug')->required(),

                    ColorPicker::make('color')->required(),
                    
                    MarkdownEditor::make('content')
                        ->required()
                        ->columnSpanFull(),
                ])->columnSpan(2)
                    ->columns(2),
            Group::make()->schema([
                Section::make('image')
                ->collapsed()
                ->schema([
                    FileUpload::make('thumbnail')
                    ->disk('public')->directory('thumbnails'),     
                ]) ->columnSpan(1),
                Section::make('Meta')->schema([
                    TagsInput::make('tags')->required(),
                    Checkbox::make('published')->required(),
                ]), 
            ]),
        ])->columns([
            'default' => 1,
            'md' => 2,
            'lg' => 3,
            'xg' => 4
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('slug'),
                Tables\Columns\CheckboxColumn::make('published'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
