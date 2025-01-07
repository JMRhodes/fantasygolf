<?php

namespace App\Services;

use App\Models\Rank;
use App\Models\Team;

class TeamService
{
    public function updateRanks(): void
    {
        $teams = Team::all();

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
    }
}
