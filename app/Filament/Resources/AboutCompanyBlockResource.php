<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutCompanyBlockResource\Pages;
use App\Models\AboutCompanyBlock;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\Card;
use Illuminate\Database\Eloquent\Builder;

class AboutCompanyBlockResource extends Resource
{
    protected static ?string $model = AboutCompanyBlock::class;

    protected static ?string $navigationIcon = 'heroicon-s-information-circle';
    protected static ?string $navigationLabel = 'Блок о компании';
    protected static ?string $navigationGroup = 'Страницы';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Заголовок')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\Textarea::make('description')
                        ->label('Описание')
                        ->rows(5),

                    Forms\Components\FileUpload::make('image')
                        ->label('Изображение')
                        ->directory('about')
                        ->image()
                        ->required()
                        ->helperText('Рекомендуемый размер: 800x600px'),

                    Forms\Components\TextInput::make('link')
                        ->label('Ссылка')
                        ->placeholder('/pages/... или https://example.com'),

                    Forms\Components\TextInput::make('button_text')
                        ->label('Текст кнопки')
                        ->default('ПОДРОБНЕЕ')
                        ->maxLength(50),

                    Forms\Components\Toggle::make('is_main')
                        ->label('Главный блок')
                        ->helperText('Главный блок отображается первым'),

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

                Tables\Columns\BooleanColumn::make('is_main')
                    ->label('Главный')
                    ->sortable(),

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
            'index' => Pages\ListAboutCompanyBlocks::route('/'),
            'create' => Pages\CreateAboutCompanyBlock::route('/create'),
            'edit' => Pages\EditAboutCompanyBlock::route('/{record}/edit'),
        ];
    }
}
