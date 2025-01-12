<?php

namespace App\Filament\Leaderboard\Resources\TeamResource\Pages;

use App\Filament\Leaderboard\Resources\TeamResource;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;

class ViewTeams extends ViewRecord
{
    protected static string $resource = TeamResource::class;

    public function getBreadcrumb(): string
    {
        return "View Team: {$this->record->name}";
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
