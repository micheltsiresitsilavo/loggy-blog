<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Filament\Resources\PostResource\RelationManagers\TagsRelationManager;
use App\Filament\Resources\PostResource\Widgets\StatsOverview;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Filament\Forms\Set;



class PostResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static ?string $recordTitleAttribute = 'title';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(
                [Section::make()->schema(
               [
                Select::make('category_id')
                    ->required()
                    ->relationship(name: 'category', titleAttribute: 'name'),
                 TextInput::make('title')
                ->required()
                ->maxLength(255)
                ->live(debounce:1500)
                ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),           
            TextInput::make('slug')
                ->required()
                ->maxLength(255),
                SpatieMediaLibraryFileUpload::make('thumbnail')->collection('posts')->disk('public')->preserveFilenames(),
                RichEditor::make('content'),
                Toggle::make('is_published')
                    ->onIcon('heroicon-m-bolt')
                    ->offIcon('heroicon-m-eye')
                ]
                )]
            );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('title')->limit('100')->sortable()->searchable(),
                TextColumn::make('slug')->limit('100'),
               IconColumn::make('is_published')->boolean(),
               SpatieMediaLibraryImageColumn::make('thumbnail')->collection('posts')
            ])
            ->filters([
                Filter::make('Published')
                    ->query(fn (Builder $query): Builder => $query->where('is_published', true))
                    ->toggle(),
                Filter::make('Unpublished')
                    ->query(fn (Builder $query): Builder => $query->where('is_published', false))
                    ->toggle(),
                SelectFilter::make('category')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()    
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
            TagsRelationManager::class
        ];
    }

    public static function getWidgets(): array
    {
        return [
            StatsOverview::class
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
