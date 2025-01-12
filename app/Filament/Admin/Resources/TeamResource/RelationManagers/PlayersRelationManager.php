<?php

namespace App\Filament\Admin\Resources\TeamResource\RelationManagers;

use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DetachAction;
use Filament\Tables\Actions\DetachBulkAction;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PlayersRelationManager extends RelationManager
{
    protected static string $relationship = 'players';

    protected static bool $isLazy = false;

    public function form(Form $form): Form
    {
        //
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                SpatieMediaLibraryImageColumn::make('avatar')
                    ->collection('player')
                    ->circular()
                    ->size(38)
                    ->label(''),
                TextColumn::make('name'),
                TextColumn::make('salary')
                    ->numeric()
                    ->badge()
                    ->prefix('$')
                    ->sortable(),
                TextColumn::make('results.points')
                    ->numeric()
                    ->default(0)
                    ->suffix('pts')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                AttachAction::make()
                    ->recordSelectSearchColumns(['name'])
                    ->preloadRecordSelect(),
            ])
            ->actions([
                ActionGroup::make([
                    DetachAction::make('Remove')
                        ->requiresConfirmation(),
                ]),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DetachBulkAction::make('Remove')
                        ->requiresConfirmation(),
                ]),
            ]);
    }
}
