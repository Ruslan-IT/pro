<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentDeliveryResource\Pages;
use App\Filament\Resources\PaymentDeliveryResource\RelationManagers;
use App\Models\PaymentDelivery;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaymentDeliveryResource extends Resource
{
    protected static ?string $model = PaymentDelivery::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationGroup = 'Страницы';

    protected static ?string $navigationLabel = 'Оплата и доставка';

    protected static ?string $modelLabel = 'страница оплаты и доставки';

    protected static ?string $pluralModelLabel = 'Оплата и доставка';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Основная информация')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Заголовок')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\FileUpload::make('image')
                            ->label('Изображение')
                            ->image()
                            ->directory('img/payment-delivery')
                            ->visibility('public')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Контент')
                    ->schema([
                        Forms\Components\RichEditor::make('payment_content')
                            ->label('Текст оплаты')
                            ->required()
                            ->columnSpanFull()
                            ->toolbarButtons([
                                'bold', 'italic', 'underline', 'strike',
                                'blockquote', 'bulletList', 'orderedList',
                                'link', 'undo', 'redo',
                            ]),

                        Forms\Components\RichEditor::make('delivery_content')
                            ->label('Текст доставки')
                            ->required()
                            ->columnSpanFull()
                            ->toolbarButtons([
                                'bold', 'italic', 'underline', 'strike',
                                'blockquote', 'bulletList', 'orderedList',
                                'link', 'undo', 'redo',
                            ]),
                    ]),

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
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Изображение')
                    ->disk('public'),

                Tables\Columns\TextColumn::make('title')
                    ->label('Заголовок')
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Создано')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Обновлено')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPaymentDeliveries::route('/'),
            'create' => Pages\CreatePaymentDelivery::route('/create'),
            'edit' => Pages\EditPaymentDelivery::route('/{record}/edit'),
        ];
    }
}
