<?php

namespace App\Filament\Leaderboard\Resources;

use App\Filament\Leaderboard\Resources\TeamResource\Pages\ListTeams;
use App\Models\Team;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TeamResource extends Resource
{
    protected static ?string $model = Team::class;

    protected static ?string $navigationLabel = 'Leaderboard';

    protected static ?string $navigationIcon = 'phosphor-ranking-duotone';

    protected static ?string $breadcrumb = 'Leaderboard';

    protected static ?string $label = 'Leaderboard';

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
                Split::make([
                    Stack::make([
                        TextColumn::make('name')
                            ->weight(FontWeight::SemiBold)
                            ->sortable()
                            ->searchable(),
                        TextColumn::make('owner.name')
                            ->size('xs')
                            ->color(Color::Gray)
                            ->searchable(),
                    ]),
                    ImageColumn::make('players.avatar')
                        ->circular()
                        ->stacked()
                        ->limit(4)
                        ->wrap(),
                    TextColumn::make('rank.points')
                        ->grow(false)
                        ->default(0)
                        ->badge()
                        ->color(Color::Gray)
                        ->sortable()
                        ->suffix(' pts'),
                ]),
            ])
            ->defaultSort('rank.points', 'desc')
            ->defaultPaginationPageOption(50)
            ->paginationPageOptions([50, 100, 250])
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
            'index' => ListTeams::route('/'),
        ];
    }
}
