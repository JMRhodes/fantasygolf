<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Player extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'uuid',
        'name',
        'salary',
    ];

    protected $attributes = [
        'name' => '',
        'salary' => 0,
        'image' => null,
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['avatar'];

    public static function booted(): void
    {
        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(
            Team::class,
            'teams_players',
            'player_id',
            'team_id'
        );
    }

    public function avatar(): Attribute
    {
        return new Attribute(
            get: fn () => $this->getFirstMediaUrl('player')
        );
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('player')
            ->singleFile();
    }
}
