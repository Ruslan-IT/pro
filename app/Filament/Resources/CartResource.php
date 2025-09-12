<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CartResource\Pages;
use App\Filament\Resources\CartResource\RelationManagers;
use App\Models\Cart;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CartResource extends Resource
{
    protected static ?string $model = Cart::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationLabel = 'Заказы';

    protected static ?string $modelLabel = 'заказ';

    protected static ?string $pluralModelLabel = 'Заказы';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Информация о клиенте')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Имя')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->label('Телефон')
                            ->required()
                            ->tel()
                            ->maxLength(20),
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->required()
                            ->email()
                            ->maxLength(255),
                    ])->columns(3),

                Forms\Components\Section::make('Детали заказа')
                    ->schema([
                        Forms\Components\Toggle::make('is_paid')
                            ->label('Оплачен')
                            ->default(false),
                        Forms\Components\Select::make('status')
                            ->label('Статус')
                            ->options(Cart::getStatuses())
                            ->default(Cart::STATUS_NEW)
                            ->required(),
                        Forms\Components\TextInput::make('total_price')
                            ->label('Общая сумма')
                            ->numeric()
                            ->prefix('₽')
                            ->required(),
                    ])->columns(3),

                Forms\Components\Section::make('Товары в заказе')
                    ->schema([
                        Forms\Components\Repeater::make('items')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Название')
                                    ->required(),
                                Forms\Components\TextInput::make('price')
                                    ->label('Цена')
                                    ->numeric()
                                    ->prefix('₽')
                                    ->required(),
                                Forms\Components\TextInput::make('quantity')
                                    ->label('Количество')
                                    ->numeric()
                                    ->required(),
                                Forms\Components\TextInput::make('color')
                                    ->label('Цвет'),
                                Forms\Components\TextInput::make('size')
                                    ->label('Размер'),
                                Forms\Components\TextInput::make('article')
                                    ->label('Артикул'),
                                Forms\Components\TextInput::make('image')
                                    ->label('Изображение')
                                    ->url(),
                            ])
                            ->columns(3)
                            ->itemLabel(fn (array $state): string => $state['title'] ?? 'Новый товар')
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Имя')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('phone')
                    ->label('Телефон')
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),

                Tables\Columns\TextColumn::make('total_price')
                    ->label('Сумма')
                    ->money('RUB')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_paid')
                    ->label('Оплата')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\SelectColumn::make('status')
                    ->label('Статус')
                    ->options(Cart::getStatuses())
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Создан')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('is_paid')
                    ->label('Оплаченные')
                    ->query(fn (Builder $query): Builder => $query->where('is_paid', true)),

                Tables\Filters\Filter::make('not_paid')
                    ->label('Неоплаченные')
                    ->query(fn (Builder $query): Builder => $query->where('is_paid', false)),

                Tables\Filters\SelectFilter::make('status')
                    ->label('Статус')
                    ->options(Cart::getStatuses()),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('markAsPaid')
                    ->label('Отметить оплаченным')
                    ->icon('heroicon-o-banknotes')
                    ->action(function (Cart $record) {
                        $record->is_paid = true;
                        $record->save();
                    })
                    ->hidden(fn (Cart $record) => $record->is_paid),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('markAsPaid')
                        ->label('Отметить оплаченными')
                        ->icon('heroicon-o-banknotes')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->is_paid = true;
                                $record->save();
                            });
                        }),
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
            'index' => Pages\ListCarts::route('/'),
            'create' => Pages\CreateCart::route('/create'),
            'edit' => Pages\EditCart::route('/{record}/edit'),
        ];
    }
}
