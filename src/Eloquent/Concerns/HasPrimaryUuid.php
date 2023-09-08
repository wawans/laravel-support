<?php

namespace Wawans\LaravelSupport\Eloquent\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasPrimaryUuid
{
    /**
     * Bootstrap this trait to the model.
     *
     * @return void
     */
    protected static function bootHasPrimaryUuid()
    {
        static::creating(function (Model $model) {
            do {
                $uuid = (string) Str::orderedUuid();
            } while (! $model->{$model->getKeyName()} && $model->where($model->getKeyName(), $uuid)->first());

            $model->{$model->getKeyName()} = $model->{$model->getKeyName()} ?: $uuid;
        });
    }

    /**
     * Get the value indicating whether the IDs are incrementing.
     *
     * @return bool
     */
    public function getIncrementing(): bool
    {
        return false;
    }

    /**
     * Get the auto-incrementing key type.
     *
     * @return string
     */
    public function getKeyType(): string
    {
        return 'string';
    }

    public static function findByUuid(string $uuid, $key = 'uuid'): ?Model
    {
        return static::where($key, $uuid)->first();
    }
}
