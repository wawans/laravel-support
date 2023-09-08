<?php

namespace Wawans\LaravelSupport\Eloquent\Concerns;

trait HasPrimaryCharId
{
    /**
     * Bootstrap this trait to the model.
     *
     * @return void
     */
    protected static function bootHasPrimaryCharId()
    {
        static::creating(function ($model) {
            $last = $model->newQueryWithoutRelationships()->max($model->getKeyName());
            $next = ($last) ? (int) $last + 1 : 1;
            $next = str_pad($next, $model->getKeyLength(), '0', STR_PAD_LEFT);

            $attempts = 0;
            $maxAttempts = 10;
            while(! $model->{$model->getKeyName()} && $model->where($model->getKeyName(), $next)->first() && $attempts < $maxAttempts) {
                $next = (int) $next + 1;
                $next = str_pad($next, $model->getKeyLength(), '0', STR_PAD_LEFT);
                $attempts++;
            }

            $model->{$model->getKeyName()} = $model->{$model->getKeyName()} ?: $next;
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
     * Get the primary key length.
     *
     * @return int
     */
    public function getKeyLength(): int
    {
        return 2;
    }

    /**
     * Get the primary key type.
     *
     * @return string
     */
    public function getKeyType(): string
    {
        return 'string';
    }
}
