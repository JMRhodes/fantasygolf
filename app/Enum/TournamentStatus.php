<?php

namespace App\Enum;

use Filament\Support\Contracts\HasLabel;

enum TournamentStatus: string implements HasLabel
{
    case UPCOMING = 'upcoming';
    case IN_PROGRESS = 'in-progress';
    case COMPLETE = 'completed';

    public function getLabel(): string
    {
        return match ($this) {
            self::UPCOMING => 'Upcoming',
            self::IN_PROGRESS => 'In Progress',
            self::COMPLETE => 'Complete',
        };
    }
}
