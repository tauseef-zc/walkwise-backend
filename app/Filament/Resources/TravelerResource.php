<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TravelerResource\Accessibility;
use App\Filament\Resources\TravelerResource\Interests;
use App\Filament\Resources\TravelerResource\Pages;
use App\Filament\Resources\TravelerResource\RelationManagers;
use App\Models\Traveler;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TravelerResource extends Resource
{
    protected static ?string $model = Traveler::class;

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                Forms\Components\TextInput::make('emergency_contact.name')->label('Contact Name'),
                Forms\Components\Select::make('accessibility')
                    ->multiple()
                    ->searchable()
                    ->options(Accessibility::getAccessibilities()),
                Forms\Components\Textarea::make('dietary_restrictions')
                    ->columnSpanFull(),
                Forms\Components\Select::make('interests')
                    ->multiple()
                    ->options(Interests::getInterests())
                    ->searchable(),
                Forms\Components\DateTimePicker::make('verified_at'),
                Forms\Components\TextInput::make('nationality')
                    ->maxLength(100),
                Forms\Components\Select::make('user_id')
                    ->relationship('user')
                    ->getOptionLabelFromRecordUsing(fn($record) => $record->name)
                    ->searchable()
                    ->preload(),
                Forms\Components\FileUpload::make('avatar')
                    ->avatar(),
                Forms\Components\FileUpload::make('passport_image')
                    ->image(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('avatar')
                    ->searchable(),
                Tables\Columns\TextColumn::make('verified_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nationality')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('passport_image'),
                Tables\Columns\TextColumn::make('user.id')
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTravelers::route('/'),
            'create' => Pages\CreateTraveler::route('/create'),
            'edit' => Pages\EditTraveler::route('/{record}/edit'),
        ];
    }
}
