<?php

namespace App\Filament\Leaderboard\Resources;

use App\Filament\Admin\Resources\TournamentResource\RelationManagers\ResultsRelationManager;
use App\Filament\Leaderboard\Resources\TournamentResource\Pages\ListTournaments;
use App\Filament\Leaderboard\Resources\TournamentResource\Pages\ViewTournament;
use App\Models\Tournament;
use Carbon\Carbon;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class TournamentResource extends Resource
{
    protected static ?string $model = Tournament::class;

    protected static ?string $navigationIcon = 'phosphor-trophy-duotone';

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
                    SpatieMediaLibraryImageColumn::make('thumbnail')
                        ->collection(Tournament::COLLECTION)
                        ->circular()
                        ->size(72)
                        ->grow(false)
                        ->label(''),
                    Stack::make([
                        TextColumn::make('name')
                            ->weight(FontWeight::SemiBold)
                            ->searchable(),
                        TextColumn::make('start_date')
                            ->date('M jS')
                            ->formatStateUsing(fn (?Model $record): string => sprintf('%s - %s',
                                Carbon::createFromDate($record->start_date)->format('M jS'),
                                Carbon::createFromDate($record->end_date)->format('M jS')
                            ))
                            ->badge(),
                    ]),
                    TextColumn::make('status')
                        ->badge(),
                ]),
            ])
            ->defaultSort('start_date', 'asc')
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make()
                    ->label('')
                    ->icon(false),
            ])
            ->bulkActions([
                //
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
            'view' => ViewTournament::route('/{record}'),
        ];
    }
}
