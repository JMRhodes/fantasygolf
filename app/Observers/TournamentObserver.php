<?php

namespace App\Observers;

use App\Models\Team;
use App\Models\Tournament;
use App\Pipes\CalculatePoints;
use App\Pipes\CalculateRankings;
use Filament\Notifications\Notification;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Cache;

class TournamentObserver
{
    /**
     * Handle the Tournament "created" event.
     */
    public function created(Tournament $tournament): void
    {
        //
    }

    /**
     * Handle the Tournament "updated" event.
     */
    public function updated(Tournament $tournament): void
    {
        Cache::flush();

        $teams = Team::all();

        app(Pipeline::class)
            ->send($teams)
            ->through([
                CalculatePoints::class,
                CalculateRankings::class,
            ])
            ->then(function () {
                Notification::make()
                    ->title(__('Team Data Synced'))
                    ->success()
                    ->seconds(5)
                    ->send();
            });
    }

    /**
     * Handle the Tournament "deleted" event.
     */
    public function deleted(Tournament $tournament): void
    {
        //
    }

    /**
     * Handle the Tournament "restored" event.
     */
    public function restored(Tournament $tournament): void
    {
        //
    }

    /**
     * Handle the Tournament "force deleted" event.
     */
    public function forceDeleted(Tournament $tournament): void
    {
        //
    }
}
