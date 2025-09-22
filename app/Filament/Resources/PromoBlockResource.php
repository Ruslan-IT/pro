<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PromoBlockResource\Pages;
use App\Models\PromoBlock;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\Card;
use Illuminate\Database\Eloquent\Builder;
use Filament\Support\Colors\Color;

class PromoBlockResource extends Resource
{
    protected static ?string $model = PromoBlock::class;

    protected static ?string $navigationIcon = 'heroicon-s-rectangle-stack';
    protected static ?string $navigationLabel = 'Блок промо';
    protected static ?string $navigationGroup = 'Страницы';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Заголовок')
                        ->maxLength(255),

                    Forms\Components\FileUpload::make('image')
                        ->label('Изображение')
                        ->directory('promo-blocks')
                        ->image()
                        ->required()
                        ->helperText('Рекомендуемый размер: 400x300px'),

                    Forms\Components\TextInput::make('link')
                        ->label('Ссылка')
                        ->placeholder('/categories или https://example.com'),

                    Forms\Components\TextInput::make('button_text')
                        ->label('Текст кнопки')
                        ->default('СМОТРЕТЬ')
                        ->maxLength(50),

                    Forms\Components\TextInput::make('orders')
                        ->label('Порядок')
                        ->numeric()
                        ->default(0),

                    Forms\Components\Toggle::make('is_active')
                        ->label('Активен')
                        ->default(true),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Изображение')
                    ->width(80)
                    ->height(60),

                Tables\Columns\TextColumn::make('title')
                    ->label('Заголовок')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('button_text')
                    ->label('Текст кнопки'),

                Tables\Columns\TextColumn::make('orders')
                    ->label('Порядок')
                    ->sortable(),

                Tables\Columns\BooleanColumn::make('is_active')
                    ->label('Активен')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('active')
                    ->label('Только активные')
                    ->query(fn (Builder $query): Builder => $query->where('is_active', true)),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('orders', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPromoBlocks::route('/'),
            'create' => Pages\CreatePromoBlock::route('/create'),
            'edit' => Pages\EditPromoBlock::route('/{record}/edit'),
        ];
    }
}
