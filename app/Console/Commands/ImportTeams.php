<?php

namespace App\Console\Commands;

use App\Models\Owner;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Console\Command;
use Spatie\SimpleExcel\SimpleExcelReader;

class ImportTeams extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-teams {csvFile}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Import teams from CSV file
        $csvFile = $this->argument('csvFile');

        $rows = SimpleExcelReader::create($csvFile)->getRows();
        $rows->each(function (array $rowProperties) {
            $this->info('Importing team: ' . json_encode($rowProperties));

            $team = Team::where('name', $rowProperties['team_name'])->firstOr(function () use ($rowProperties) {
                $owner = Owner::where('name', $rowProperties['owner'])->firstOr(function () use ($rowProperties) {
                    return Owner::create([
                        'name' => $rowProperties['owner'],
                    ]);
                });

                return Team::create([
                    'name' => $rowProperties['team_name'],
                    'owner_id' => $owner->id,
                ]);
            });

            // Detach all players from the team
            $team->players()->detach();

            // Attach players to the team
            $team->players()->attach($this->getPlayerResource($rowProperties['player_1']));
            $team->players()->attach($this->getPlayerResource($rowProperties['player_2']));
            $team->players()->attach($this->getPlayerResource($rowProperties['player_3']));
            $team->players()->attach($this->getPlayerResource($rowProperties['player_4']));
        });
    }

    // Add this method to the ImportTeams class
    public function getPlayerResource($playerName): ?Player
    {
        $player = Player::where('name', $playerName)->first();
        if (! $player) {
            $this->error('Player not found: ' . $playerName);

            return null;
        }

        return $player;
    }
}
