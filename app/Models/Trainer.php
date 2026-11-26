<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;

class Trainer extends Model
{
    use SoftDeletes, Searchable;

    protected $fillable = [
        'name',
        'apellido',
        'avatar',
        'slug',
    ];

    protected $appends = ['avatar_url'];

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'apellido' => $this->apellido,
            'slug' => $this->slug ?? '',
        ];
    }

    public function searchableAs()
    {
        return 'trainers_index';
    }

    public function shouldBeSearchable()
    {
        return is_null($this->deleted_at);
    }

    // URL completa de la imagen
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            if (file_exists(public_path('images/' . $this->avatar))) {
                return asset('images/' . $this->avatar);
            }

            if (file_exists(storage_path('app/public/images/' . $this->avatar))) {
                return asset('storage/images/' . $this->avatar);
            }
        }

        return null;
    }

    // Genera el slug automáticamente
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($trainer) {
            $trainer->slug = Str::slug($trainer->name . ' ' . $trainer->apellido);

            $originalSlug = $trainer->slug;
            $count = 1;
            while (static::where('slug', $trainer->slug)->withTrashed()->exists()) {
                $trainer->slug = $originalSlug . '-' . $count;
                $count++;
            }
        });

        static::updating(function ($trainer) {
            if ($trainer->isDirty(['name', 'apellido'])) {
                $trainer->slug = Str::slug($trainer->name . ' ' . $trainer->apellido);

                $originalSlug = $trainer->slug;
                $count = 1;
                while (static::where('slug', $trainer->slug)
                            ->where('id', '!=', $trainer->id)
                            ->withTrashed()
                            ->exists()) {
                    $trainer->slug = $originalSlug . '-' . $count;
                    $count++;
                }
            }
        });
    }

    // Trainers activos (no eliminados)
    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function restoreTrainer()
    {
        return $this->restore();
    }

    public function forceDeleteTrainer()
    {
        if ($this->avatar) {
            $path = public_path('images/' . $this->avatar);
            if (file_exists($path)) {
                @unlink($path);
            }
        }

        return $this->forceDelete();
    }
}