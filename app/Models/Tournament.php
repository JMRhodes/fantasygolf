<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Tournament extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public const COLLECTION = 'tournament';

    protected $fillable = [
        'uuid',
        'name',
        'description',
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
}
