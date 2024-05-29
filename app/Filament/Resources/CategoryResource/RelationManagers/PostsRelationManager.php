<?php

namespace App\Filament\Resources\CategoryResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
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
               Section::make()->schema(
               [
                Select::make('category_id')
                    ->relationship(name: 'category', titleAttribute: 'name'),
                TextInput::make('title')
                    ->required()
                     ->searchable()
                    ->maxLength(255)
                    ,
                TextInput::make('slug')
                    ->required()
                    ->maxLength(255),
                SpatieMediaLibraryFileUpload::make('thumbnail')->collection('posts')->disk('public')->preserveFilenames(),
                RichEditor::make('content'),
                Toggle::make('is_published')
                    ->onIcon('heroicon-m-bolt')
                    ->offIcon('heroicon-m-eye')
                ]
                )
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('title')->limit('100')->sortable(),
                TextColumn::make('slug')->limit('100'),
               IconColumn::make('is_published')->boolean(),
               SpatieMediaLibraryImageColumn::make('thumbnail')->collection('posts')
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
