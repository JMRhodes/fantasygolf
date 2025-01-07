<?php

namespace App\Filament\Leaderboard\Resources;

use App\Filament\Leaderboard\Resources\PlayerResource\Pages\ListPlayers;
use App\Models\Player;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PlayerResource extends Resource
{
    protected static ?string $model = Player::class;

    protected static ?string $navigationIcon = 'phosphor-identification-badge-duotone';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('avatar')
                    ->collection('player')
                    ->circular()
                    ->size(38)
                    ->label(''),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('salary')
                    ->numeric()
                    ->prefix('$')
                    ->sortable(),
                TextColumn::make('total_points')
                    ->label('Points')
                    ->numeric(),
            ])
            ->defaultPaginationPageOption(50)
            ->paginationPageOptions([25, 50, 100])
            ->filters([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                //
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
            'index' => ListPlayers::route('/'),
        ];
    }
}
