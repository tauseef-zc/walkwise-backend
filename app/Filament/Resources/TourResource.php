<?php

namespace App\Filament\Resources;

use App\Enums\TourStatusEnum;
use App\Filament\Resources\TourResource\Pages;
use App\Filament\Resources\TourResource\RelationManagers;
use App\Models\Tour;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TourResource extends Resource
{
    protected static ?string $model = Tour::class;

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Split::make([
                    Forms\Components\Section::make([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(150),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(150),
                        Forms\Components\Select::make('guide_id')
                            ->relationship('guide', 'name')
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('tour_category_id')
                            ->label('Tour Category')
                            ->relationship('category', 'category')
                            ->searchable()
                            ->preload(),
                        Forms\Components\Textarea::make('overview')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->default(0.00)
                            ->prefix('$'),
                        Forms\Components\TextInput::make('start_point')
                            ->maxLength(100),
                        Forms\Components\TextInput::make('end_point')
                            ->maxLength(100),
                        Forms\Components\TextInput::make('max_packs')
                            ->required()
                            ->numeric()
                            ->default(0),
                        Forms\Components\Textarea::make('inclusions')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('exclusions')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('conditions')
                            ->columnSpanFull(),

                    ])
                    ->columns(2),
                    Forms\Components\Section::make([
                        Forms\Components\Toggle::make('is_private')
                            ->required(),
                        Forms\Components\Toggle::make('featured')
                            ->required(),
                        Forms\Components\Select::make('status')
                            ->options(TourStatusEnum::fieldset())
                            ->required(),
                    ])->grow(false)
                ])
                ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('guide.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('max_packs')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('category.category')
                    ->label('Tour Category')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            RelationManagers\ImagesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTours::route('/'),
            'create' => Pages\CreateTour::route('/create'),
            'edit' => Pages\EditTour::route('/{record}/edit'),
        ];
    }
}
