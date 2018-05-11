<?php

namespace App\Http\Resources;

use Illuminate\Support\Str;
use Jenssegers\Mongodb\Eloquent\Model;

class BaseResource extends Model
{
    /**
     * The type of key to type cast.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The list of attributes that are appended to the array & json representations.
     *
     * @var array
     */
    protected $appends = [
        'uri'
    ];

    /**
     * The name of the route to associated the model with.
     *
     * (Optional)
     *
     * @var string
     */
    protected $route;

    public function __construct(array $attributes = [])
    {
        // Append some special values to the hidden attributes.
        $this->hidden = array_merge($this->hidden, [
            '_id',
            'updated_at',
            'created_at',
        ]);

        parent::__construct($attributes);
    }

    /**
     * Gets the route name that the model is associated with.
     *
     * @return string
     */
    protected function getRouteName()
    {
        if (! isset($this->route)) {
            return str_replace(
                '\\',
                '',
                Str::snake(class_basename($this))
            );
        }
        return $this->route;
    }

    /**
     * Get the name of the key
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'id';
    }

    /**
     * Define a computed property on all resource models called `uri`.
     *
     * @return string
     */
    public function getUriAttribute()
    {
        return route($this->getRouteName(), [$this->getRouteKeyName() => $this->getRouteKey()]);
    }
}
