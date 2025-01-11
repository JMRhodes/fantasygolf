<?php

namespace App\Console\Commands;

use App\Models\Player;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SyncPlayerData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-player-data';

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
        $response = Http::get('https://www.pgatour.com/_next/data/pgatour-prod-1.72.5/en/players.json');

        $players = $response->collect('pageProps.players.players');
        $players->each(function ($player) {
            $record = Player::where('name', $player['displayName'])->first();
            if (! $record) {
                $this->error('Player not found: ' . $player['displayName']);

                return true;
            }

            $record->pga_id = $player['id'];
            $record->save();

            if (! $record->getFirstMedia(Player::COLLECTION)) {
                $record->addMediaFromUrl(
                    "https://pga-tour-res.cloudinary.com/image/upload/c_thumb,g_face,w_148,h_148,z_0.7/headshots_{$record->pga_id}.jpg"
                )
                    ->toMediaCollection(Player::COLLECTION);
            }
        });
    }
}
