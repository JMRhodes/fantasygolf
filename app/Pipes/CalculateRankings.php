<?php

namespace App\Pipes;

use App\Models\Team;
use Closure;
use Illuminate\Support\Collection;

class CalculateRankings
{
    public function handle(Collection $teams, Closure $next)
    {
        //        $teams = Team::all()->sortBy('rank.points', SORT_REGULAR, true);
        //        $teams->each(function ($team, $index) {
        //            $team->rank->rank = $index + 1;
        //            $team->rank->save();
        //        });
    }
}
