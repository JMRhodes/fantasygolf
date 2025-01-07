<?php

namespace App\Filament\Leaderboard\Resources\TournamentResource\Pages;

use App\Filament\Leaderboard\Resources\TournamentResource;
use Filament\Resources\Pages\ListRecords;

class ListTournaments extends ListRecords
{
    protected static string $resource = TournamentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
