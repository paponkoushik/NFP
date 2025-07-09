<?php

namespace App\Models\Traits;

use App\Models\Organisation;
use Illuminate\Support\Str;

trait Sluggable
{
    /**
     * Setup model event hook.
     *
     * @return void
     */
    protected static function bootSluggable()
    {
        static::creating(function ($model) {
            $sluggableKey = $model->getSluggableKey($model);
            $model->slug = $model->generateSlug($model->{$sluggableKey}, $sluggableKey);
        });
    }

    /**
     * This should be the name of which key you want for slug
     */
    public function getSluggableKey($model): string
    {
        if ($model instanceof Organisation) {
            return 'org_name';
        }

        return 'title';
    }

    private function generateSlug($value, $key): string
    {
        if (static::whereSlug($slug = Str::slug($value))->exists()) {
            $max = static::where("{$key}", $value)->latest()->value('slug');

            if (isset($max[-1]) && is_numeric($max[-1])) {
                return preg_replace_callback(
                    '/(\d+)$/',
                    fn ($mathces) => $mathces[1] + 1,
                    $max
                );
            }

            return "{$slug}-2";
        }

        return $slug;
    }
}
