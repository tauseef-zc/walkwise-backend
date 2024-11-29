<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GuideResource\Expertise;
use App\Filament\Resources\GuideResource\Pages;
use App\Filament\Resources\GuideResource\RelationManagers;
use App\Models\Guide;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GuideResource extends Resource
{
    protected static ?string $model = Guide::class;

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'heroicon-s-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('phone')
                    ->required()
                    ->tel()
                    ->maxLength(20),
                Forms\Components\Textarea::make('bio')
                    ->columnSpanFull(),
                Forms\Components\Select::make('expertise')
                    ->options(Expertise::getExpertises())
                    ->multiple(),
                Forms\Components\TextInput::make('experience')
                    ->numeric(),
                Forms\Components\FileUpload::make('avatar')
                    ->directory('guide/images')
                    ->avatar()
                    ->image(),
                Forms\Components\FileUpload::make('documents')
                    ->directory('guide/documents')
                    ->multiple(),
                Forms\Components\Toggle::make('has_vehicle'),
                Forms\Components\TextInput::make('rating')
                    ->numeric()
                    ->default(0),
                Forms\Components\DateTimePicker::make('verified_at'),
                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->relationship('user')
                    ->getOptionLabelFromRecordUsing(fn($record) => $record->name)
                    ->searchable()
                    ->preload(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')
                    ->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\IconColumn::make('has_vehicle')
                    ->boolean(),
                Tables\Columns\TextColumn::make('rating')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('verified_at')
                    ->dateTime()
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGuides::route('/'),
            'create' => Pages\CreateGuide::route('/create'),
            'edit' => Pages\EditGuide::route('/{record}/edit'),
        ];
    }
}
