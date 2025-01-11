<?php

namespace App\Models;

use App\Observers\PlayerObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

#[ObservedBy([PlayerObserver::class])]
class Player extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public const string COLLECTION = 'player';

    protected $fillable = [
        'uuid',
        'pga_id',
        'name',
        'salary',
    ];

    protected $attributes = [
        'name' => '',
        'salary' => 0,
        'total_points' => 0,
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

    public function totalPoints(): Attribute
    {
        return new Attribute(
            get: fn () => Cache::remember("player_{$this->id}_points", 3600, function () {
                return $this->results()->sum('points');
            })
        );
    }

    public function results(): HasMany
    {
        return $this->hasMany(Results::class);
    }

    public function avatar(): Attribute
    {
        return new Attribute(
            get: fn () => $this->getFirstMediaUrl(self::COLLECTION)
        );
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::COLLECTION)
            ->useFallbackUrl('https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF')
            ->singleFile();
    }

    protected function casts()
    {
        return [
            'uuid' => 'string',
            'pga_id' => 'integer',
            'name' => 'string',
            'salary' => 'integer',
            'total_points' => 'integer',
        ];
    }
}
