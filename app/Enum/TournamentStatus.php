<?php

namespace App\Enum;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum TournamentStatus: string implements HasColor, HasLabel
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

    public function getColor(): string
    {
        return match ($this) {
            self::UPCOMING => 'gray',
            self::IN_PROGRESS => 'warning',
            self::COMPLETE => 'success',
        };
    }
}
