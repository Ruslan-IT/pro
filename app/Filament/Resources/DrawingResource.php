<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DrawingResource\Pages;
use App\Filament\Resources\DrawingResource\RelationManagers;
use App\Models\Drawing;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class DrawingResource extends Resource
{
    protected static ?string $model = Drawing::class;

    protected static ?string $navigationIcon = 'heroicon-o-paint-brush';

    protected static ?string $navigationLabel = 'Виды нанесения';

    protected static ?string $modelLabel = 'вид нанесения';

    protected static ?string $pluralModelLabel = 'Виды нанесения';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationGroup = 'Контент';





    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }


    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Виды нанесения можно добавлять';
    }





    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Основная информация')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Название')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                if ($operation === 'edit') {
                                    return;
                                }

                                $set('url', Str::slug($state));
                                $set('seo_h1', $state);
                                $set('seo_title', $state . ' | MV Gifts');
                            }),

                        Forms\Components\TextInput::make('url')
                            ->label('URL')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        Forms\Components\FileUpload::make('image')
                            ->label('Изображение')
                            ->image()
                            ->directory('img/Drawing')
                            ->visibility('public')
                            ->columnSpanFull(),

                        Forms\Components\RichEditor::make('text')
                            ->label('Текст')
                            ->required()
                            ->columnSpanFull()
                            ->toolbarButtons([
                                'bold', 'italic', 'underline', 'strike',
                                'blockquote', 'bulletList', 'orderedList',
                                'link', 'undo', 'redo',
                            ]),
                    ])->columns(2),

                Forms\Components\Section::make('SEO настройки')
                    ->schema([
                        Forms\Components\TextInput::make('seo_title')
                            ->label('SEO Title')
                            ->maxLength(255),

                        Forms\Components\Textarea::make('seo_description')
                            ->label('SEO Description')
                            ->maxLength(500)
                            ->rows(3),

                        Forms\Components\TextInput::make('seo_h1')
                            ->label('H1 Заголовок')
                            ->maxLength(255),
                    ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([


                Tables\Columns\TextColumn::make('title')
                    ->label('Название')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('url')
                    ->label('URL')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Создано')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Обновлено')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListDrawings::route('/'),
            'create' => Pages\CreateDrawing::route('/create'),
            'edit' => Pages\EditDrawing::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
