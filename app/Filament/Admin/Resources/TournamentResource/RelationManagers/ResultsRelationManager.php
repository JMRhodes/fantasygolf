<?php

namespace App\Filament\Admin\Resources\TournamentResource\RelationManagers;

use App\Models\Player;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DetachAction;
use Filament\Tables\Actions\DetachBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ResultsRelationManager extends RelationManager
{
    protected static string $relationship = 'results';

    protected static bool $isLazy = false;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('player_id')
                    ->options(fn () => Player::orderBy('name')->pluck('name', 'id'))
                    ->preload()
                    ->searchable()
                    ->required(),
                TextInput::make('position')
                    ->required(),
                TextInput::make('points')
                    ->numeric()
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('player.name')
            ->columns([
                TextColumn::make('position')
                    ->grow(false),
                TextColumn::make('player.name')
                    ->grow(true),
                TextColumn::make('points')
                    ->grow(false),
            ])
            ->emptyStateDescription('No results have been added yet. Check back after this tournament has finalized.')
            ->defaultSort('position', 'asc')
            ->defaultPaginationPageOption(25)
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->actions([
                EditAction::make(),
                DetachAction::make('Remove'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DetachBulkAction::make('Remove'),
                ]),
            ]);
    }
}
