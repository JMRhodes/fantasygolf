<?php

namespace Database\Seeders;

use App\Models\Player;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $playerData = Storage::disk('public')->json('data/players.json');

        foreach ($playerData as $player) {
            Player::firstOrCreate([
                'name' => $player['name'],
                'salary' => $player['salary'],
            ]);
            // $playerModel->addMediaFromUrl($player['image'])->toMediaCollection('player');
        }
    }
}
