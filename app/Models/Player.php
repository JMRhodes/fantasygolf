<?php

namespace App\Models;

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
    ];

    public static function booted(): void
    {
        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function team(): BelongsToMany
    {
        return $this->belongsToMany(Team::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('player')
            ->singleFile();
    }
}
