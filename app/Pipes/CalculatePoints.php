<?php

namespace App\Pipes;

use App\Models\Rank;
use Closure;
use Illuminate\Support\Collection;

class CalculatePoints
{
    public function handle(Collection $teams, Closure $next)
    {
        foreach ($teams as $team) {
            $total_points = $team->players->map(function ($player) {
                return $player->results->sum('points');
            });

            $teamRank = Rank::where('team_id', $team->id)->firstOr(function () use ($team) {
                return Rank::create([
                    'team_id' => $team->id,
                    'rank' => 0,
                    'previous' => 0,
                    'points' => 0,
                ]);
            });

            $teamRank->points = $total_points->sum();
            $teamRank->save();
        }

        return $next($teams);
    }
}
