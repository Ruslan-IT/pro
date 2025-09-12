<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PortfolioResource\Pages;
use App\Filament\Resources\PortfolioResource\RelationManagers;
use App\Models\Portfolio;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class PortfolioResource extends Resource
{
    protected static ?string $model = Portfolio::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationLabel = 'Портфолио';

    protected static ?string $navigationGroup = 'Контент';
    protected static ?string $pluralModelLabel = 'Портфолио';




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
                            ->label('Полное описание')
                            ->fileAttachmentsDirectory('img/portfolio')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Изображения')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('Основное изображение')
                            ->image()
                            ->directory('img/portfolio/main')
                            ->maxSize(2048),

                    ])
                    ->columns(1),



                Forms\Components\Section::make('SEO')
                    ->schema([
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
                    ->columns(1),

                Forms\Components\Section::make('Настройки публикации')
                    ->schema([
                        Forms\Components\Toggle::make('is_published')
                            ->label('Опубликовано')
                            ->default(true),
                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Дата публикации')
                            ->default(now()),

                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('id')
                    ->label('Id')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Заголовок')
                    ->searchable(),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Дата публикации')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('Опубликовано')
                    ->boolean(),

            ])
            ->filters([

                Tables\Filters\Filter::make('is_published')
                    ->label('Опубликованные')
                    ->query(fn (Builder $query) => $query->where('is_published', true)),
                Tables\Filters\Filter::make('unpublished')
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
            'index' => Pages\ListPortfolios::route('/'),
            'create' => Pages\CreatePortfolio::route('/create'),
            'edit' => Pages\EditPortfolio::route('/{record}/edit'),
        ];
    }
}
