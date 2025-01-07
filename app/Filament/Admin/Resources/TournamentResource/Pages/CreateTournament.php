<?php

namespace App\Filament\Admin\Resources\TournamentResource\Pages;

use App\Filament\Admin\Resources\TournamentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTournament extends CreateRecord
{
    protected static string $resource = TournamentResource::class;

    protected static bool $canCreateAnother = false;
}
