<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $label = 'Категория';
    protected static ?string $pluralLabel = 'Категории';

    protected static ?string $navigationLabel = 'Категории';

    protected static ?string $navigationGroup = 'Список категорий';




    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Group::make()->schema([
                    Forms\Components\Section::make()->schema([

                        TextInput::make('title')->label('Название')
                            ->required()
                            ->maxLength(255)
                            ->live(true)
                            ->afterStateUpdated(function (Forms\Set $set, Forms\Get $get, ?string $state, string $operation ) {
                                if($operation === 'edit' && $get('url')) {
                                    return;
                                }
                                $set('url', Str::slug($state));
                            }),

                        TextInput::make('url  ')->label('url')
                            ->unique(ignoreRecord: true)
                            ->helperText('Генерация автом1.')
                            ->maxLength(255),

                        /*TextInput::make('flag ')->label('flag ')
                            ->required()
                            ->maxLength(255),*/

                        TextInput::make('meta_title ')->label('meta_title')

                            ->maxLength(255),

                        TextInput::make('meta_keywords ')->label('meta_keywords')

                            ->maxLength(255),

                        RichEditor::make('meta_description ')->label('meta_description')

                            ->maxLength(255),


                    ])
                ])->columnSpan(2),

                Forms\Components\Group::make()->schema([
                    Forms\Components\Section::make()->schema([

                        Select::make('id_parent ')->label('id_parent ')
                            ->options(function () {
                                return self::getCategoriesTree(Category::all());
                            })
                            ->disableOptionWhen(function (Forms\Get $get, string $value ) {
                                return $value == $get('id');
                            })
                            ->placeholder('Root category'),

                    ])
                ]),

            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('url')
                    ->numeric(),

                Tables\Columns\TextColumn::make('id_parent')
                    ->numeric()


            ])
            ->filters([
                //
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }

    public static function getCategoriesTree($categories, $parentID = null, $depth = 0): array
    {
        $options = [];
        foreach ($categories->where('id_parent', $parentID) as $category) {

            $prefix = str_repeat('-', $depth);
            $options[$category->id] = $prefix . $category->title;
            $children = self::getCategoriesTree($categories, $category->id, $depth + 1);
            $options += $children;
        }

        return $options;

    }


}
