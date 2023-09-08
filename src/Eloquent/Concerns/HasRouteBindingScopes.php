<?php

namespace Wawans\LaravelSupport\Eloquent\Concerns;

trait HasRouteBindingScopes
{
    /**
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereRouteKey($query, $value)
    {
        $keys = $this->getRouteKeyName();

        if (!is_array($keys)) {
            return $query->where($this->getRouteKeyName(), $value);
        }

        $values = explode($this->getDelimiter(), $value);

        return (count($keys) == count($values))
            ? $query->where(array_combine($keys, $values))
            : $query->where(array_combine($keys, array_fill(0, count($keys)-1, null)));
    }

    /**
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $value
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|static|null
     */
    public function scopeFirstRouteKey($query, $value, $columns = ['*'])
    {
        return $query->whereRouteKey($value)->first($columns);
    }

    /**
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $value
     * @return \Illuminate\Database\Eloquent\Builder
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException<\Illuminate\Database\Eloquent\Model>
     */
    public function scopeFirstRouteKeyOrFail($query, $value, $columns = ['*'])
    {
        return $query->whereRouteKey($value)->firstOrFail($columns);
    }

    /**
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $value
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|static|null
     */
    public function scopeFindId($query, $value, $columns = ['*'])
    {
        return $query->firstRouteKey($value, $columns);
    }

    /**
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $value
     * @return \Illuminate\Database\Eloquent\Builder
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException<\Illuminate\Database\Eloquent\Model>
     */
    public function scopeFindOrFailId($query, $value, $columns = ['*'])
    {
        return $query->firstRouteKeyOrFail($value, $columns);
    }
}
