<?php

namespace App\Filament\Leaderboard\Resources\TeamResource\Pages;

use App\Filament\Leaderboard\Resources\TeamResource;
use Filament\Resources\Pages\ListRecords;

class ListTeams extends ListRecords
{
    protected static string $resource = TeamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
