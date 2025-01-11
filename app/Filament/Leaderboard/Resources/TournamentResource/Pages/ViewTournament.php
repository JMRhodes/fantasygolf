<?php

namespace App\Filament\Leaderboard\Resources\TournamentResource\Pages;

use App\Filament\Leaderboard\Resources\TournamentResource;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;

class ViewTournament extends ViewRecord
{
    protected static string $resource = TournamentResource::class;

    public function getBreadcrumb(): string
    {
        return "View {$this->record->name}";
    }

    public function getTitle(): string|Htmlable
    {
        return $this->record->name;
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
            ]);
    }
}
