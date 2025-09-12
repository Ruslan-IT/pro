<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Filament\Resources\ArticleResource\RelationManagers;
use App\Models\Article;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Статьи';

    protected  static ?string $navigationGroup = 'Контент';

    protected static ?string $pluralModelLabel = 'Статьи';


    protected static ?int $navigationSort = 3;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Основная информация')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Заголовок')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, $set) {
                                if (empty($state)) return;
                                $set('slug', Str::slug($state));
                            }),
                        Forms\Components\TextInput::make('slug')
                            ->label('URL-адрес')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Forms\Components\Textarea::make('excerpt')
                            ->label('Краткое описание')
                            ->rows(3)
                            ->maxLength(500),
                        Forms\Components\RichEditor::make('content')
                            ->label('Содержание')
                            ->required()
                            ->fileAttachmentsDirectory('articles/attachments')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Изображение')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('Изображение статьи')
                            ->image()
                            ->directory('img/articles/main')
                            ->maxSize(2048),
                            /*->imageResizeMode('cover')
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeTargetWidth('800')
                            ->imageResizeTargetHeight('450'),*/
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Дополнительная информация')
                    ->schema([
                        Forms\Components\TextInput::make('author')
                            ->label('Автор')
                            ->maxLength(255),
                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Дата публикации')
                            ->default(now()),
                        Forms\Components\TextInput::make('meta_title')
                            ->label('Meta заголовок')
                            ->maxLength(255),
                        Forms\Components\Textarea::make('meta_description')
                            ->label('Meta описание')
                            ->rows(2)
                            ->maxLength(500),
                        Forms\Components\Textarea::make('meta_keywords')
                            ->label('Meta ключевые слова')
                            ->rows(2)
                            ->maxLength(500),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Настройки публикации')
                    ->schema([
                        Forms\Components\Toggle::make('is_published')
                            ->label('Опубликовано')
                            ->default(true),
                        Forms\Components\TextInput::make('sort_order')
                            ->label('Порядок сортировки')
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('title')
                    ->label('Заголовок')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Дата публикации')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('Опубликовано')
                    ->boolean(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Сортировка')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('is_published')
                    ->label('Опубликованные')
                    ->query(fn (Builder $query) => $query->where('is_published', true)),
                Tables\Filters\Filter::make('not_published')
                    ->label('Неопубликованные')
                    ->query(fn (Builder $query) => $query->where('is_published', false)),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('publish')
                        ->label('Опубликовать')
                        ->icon('heroicon-m-check')
                        ->action(fn ($records) => $records->each->update(['is_published' => true])),
                    Tables\Actions\BulkAction::make('unpublish')
                        ->label('Снять с публикации')
                        ->icon('heroicon-m-x-mark')
                        ->action(fn ($records) => $records->each->update(['is_published' => false])),
                ]),
            ])
            ->defaultSort('published_at', 'desc')
            ->reorderable('sort_order');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
