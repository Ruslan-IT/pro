<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Filament\Resources\ContactResource\RelationManagers;
use App\Models\Contact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-phone';

    protected static ?string $navigationGroup = 'Страницы';

    protected static ?string $navigationLabel = 'Контакты';

    protected static ?string $modelLabel = 'страница контактов';

    protected static ?string $pluralModelLabel = 'Контакты';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Контактная информация')
                    ->schema([
                        Forms\Components\TextInput::make('phone')
                            ->label('Телефон')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('address')
                            ->label('Адрес')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('work_time')
                            ->label('Время работы')
                            ->required()
                            ->maxLength(255),
                    ]),

                Forms\Components\Section::make('Реквизиты компании')
                    ->schema([
                        Forms\Components\TextInput::make('company_name')
                            ->label('Название компании')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('inn')
                            ->label('ИНН')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('kpp')
                            ->label('КПП')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('ogrn')
                            ->label('ОГРН')
                            ->maxLength(255),

                        Forms\Components\Textarea::make('legal_address')
                            ->label('Юридический адрес')
                            ->required()
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Дополнительно')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('Изображение')
                            ->image()
                            ->directory('img/contacts')
                            ->visibility('public')
                            ->columnSpanFull(),
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

                Tables\Columns\TextColumn::make('phone')
                    ->label('Телефон')
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),

                Tables\Columns\TextColumn::make('company_name')
                    ->label('Компания')
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
            'index' => Pages\ListContacts::route('/'),
            'create' => Pages\CreateContact::route('/create'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }
}
