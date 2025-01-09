<?php

namespace App\Pipes;

use App\Models\Rank;
use Closure;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CalculateRankings
{
    public function handle(Collection $teams, Closure $next)
    {
        $rankings = DB::select('SELECT *, DENSE_RANK() OVER (ORDER BY points DESC) AS `dense_rank` FROM ranks');

        if (! $rankings) {
            return $next($teams);
        }

        foreach ($rankings as $ranking) {
            $rank = Rank::where('id', $ranking->id)->first();
            if (! $rank) {
                continue;
            }

            $rank->previous = $rank->rank;
            $rank->rank = $ranking->dense_rank;
            $rank->save();
        }

        return $next($teams);
    }
}
