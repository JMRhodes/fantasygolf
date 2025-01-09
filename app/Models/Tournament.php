<?php

namespace App\Models;

use App\Enum\TournamentStatus;
use App\Observers\TournamentObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

#[ObservedBy(TournamentObserver::class)]
class Tournament extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public const COLLECTION = 'tournament';

    protected $fillable = [
        'uuid',
        'name',
        'description',
        'status',
        'start_date',
        'end_date',
    ];

    protected $appends = ['thumbnail'];

    public static function booted(): void
    {
        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    public function thumbnail(): Attribute
    {
        return new Attribute(
            get: fn () => $this->getFirstMediaUrl(self::COLLECTION)
        );
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::COLLECTION)
            ->singleFile();
    }

    public function results(): HasMany
    {
        return $this->hasMany(Results::class);
    }

    protected function casts()
    {
        return [
            'status' => TournamentStatus::class,
        ];
    }
}
