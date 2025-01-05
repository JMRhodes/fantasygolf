<?php

namespace App\Filament\Resources;

use App\Enum\TournamentStatus;
use App\Filament\Resources\TournamentResource\Pages\CreateTournament;
use App\Filament\Resources\TournamentResource\Pages\EditTournament;
use App\Filament\Resources\TournamentResource\Pages\ListTournaments;
use App\Filament\Resources\TournamentResource\RelationManagers\ResultsRelationManager;
use App\Models\Tournament;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TournamentResource extends Resource
{
    protected static ?string $model = Tournament::class;

    protected static ?string $navigationIcon = 'phosphor-trophy';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Team Information')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->columnSpan(2)
                            ->maxLength(255),
                        DatePicker::make('start_date')
                            ->columnSpan(1)
                            ->format('Y-m-d'),
                        DatePicker::make('end_date')
                            ->columnSpan(1)
                            ->format('Y-m-d'),
                        Select::make('status')
                            ->columnSpan(2)
                            ->options(TournamentStatus::class),
                    ])
                    ->columns(2)
                    ->columnSpan(8),
                Section::make()
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('thumbnail')
                            ->collection(Tournament::COLLECTION),
                    ])
                    ->columnSpan(4),
            ])
            ->columns(12);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('thumbnail')
                    ->collection(Tournament::COLLECTION)
                    ->circular()
                    ->size(48)
                    ->label(''),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('start_date')
                    ->date('M jS')
                    ->sortable(),
                TextColumn::make('end_date')
                    ->date('M jS')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            'results' => ResultsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTournaments::route('/'),
            'create' => CreateTournament::route('/create'),
            'edit' => EditTournament::route('/{record}/edit'),
        ];
    }
}
