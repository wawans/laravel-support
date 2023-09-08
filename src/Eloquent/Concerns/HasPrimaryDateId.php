<?php

namespace Wawans\LaravelSupport\Eloquent\Concerns;

trait HasPrimaryDateId
{
    /**
     * Bootstrap this trait to the model.
     *
     * @return void
     */
    protected static function bootHasPrimaryDateId()
    {
        static::creating(function ($model) {
            $date = $model->getDateId();
            $last = $model->where($model->getKeyName(), 'LIKE', "%$date%")->max($model->getKeyName());
            $next = ($last) ? $last + 1 : $date . str_pad('1',$model->getKeyLength() - strlen($date),'0', STR_PAD_LEFT);

            $attempts = 0;
            $maxAttempts = 10;
            while(! $model->{$model->getKeyName()} && $model->where($model->getKeyName(), $next)->first() && $attempts < $maxAttempts) {
                $next = $next + 1;
                $attempts++;
            }

            $model->{$model->getKeyName()} = $model->{$model->getKeyName()} ?: $next;
        });
    }

    /**
     * Get current date for ID value.
     *
     * @return string
     */
    public function getDateId(): string
    {
        return now()->format('ymd');
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
        return 11;
    }
}
