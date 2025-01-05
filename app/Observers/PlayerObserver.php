<?php

namespace App\Observers;

use App\Models\Player;

class PlayerObserver
{
    /**
     * Handle the Player "created" event.
     */
    public function created(Player $player): void
    {
        //
    }

    /**
     * Handle the Player "updated" event.
     */
    public function updated(Player $player): void
    {
        if (! $player->pga_id) {
            return;
        }

        if (! $player->getFirstMedia(Player::COLLECTION)) {
            $player->addMediaFromUrl(
                "https://pga-tour-res.cloudinary.com/image/upload/c_thumb,g_face,w_148,h_148,z_0.7/headshots_{$player->pga_id}.jpg"
            )
                ->toMediaCollection(Player::COLLECTION);
        }
    }

    /**
     * Handle the Player "deleted" event.
     */
    public function deleted(Player $player): void
    {
        //
    }

    /**
     * Handle the Player "restored" event.
     */
    public function restored(Player $player): void
    {
        //
    }

    /**
     * Handle the Player "force deleted" event.
     */
    public function forceDeleted(Player $player): void
    {
        //
    }
}
