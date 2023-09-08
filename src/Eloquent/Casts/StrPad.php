<?php

namespace Wawans\LaravelSupport\Eloquent\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsInboundAttributes;

/**
 * Wawans\LaravelSupport\Eloquent\Casts\StrPad
 *
 * @method static StrPad __toString()
 */
class StrPad implements CastsInboundAttributes
{
    /**
     * @var int
     */
    protected $length;

    /**
     * @var string
     */
    protected $char;

    /**
     * @var int
     */
    protected $type;

    /**
     * Constructor.
     *
     * @param int $length
     * @param string $char
     * @param int $type
     */
    public function __construct(int $length = 0, string $char = '0', int $type = STR_PAD_LEFT)
    {
        $this->length = $length;
        $this->char = $char;
        $this->type = $type;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function set($model, $key, $value, $attributes)
    {
        return str_pad($value, $this->length, $this->char, $this->type);
    }
}
