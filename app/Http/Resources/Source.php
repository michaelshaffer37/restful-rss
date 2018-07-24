<?php

namespace App\Http\Resources;

/**
 * Class Source
 *
 * @package App\Http\Resources
 */
class Source extends BaseResource
{
    /**
     * @var array
     */
    protected $fillable = [
        '_id',
        'url',
        'name',
    ];

    /**
     * Defines the relation between Sources & Loaders
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function loaders()
    {
        return $this->hasMany(Loader::class);
    }

    /**
     * Updates the Source Status to one of the status states.
     *
     * @param string $status
     * @param array  $attributes
     *
     * @return bool
     */
    public function updateStatus(string $status, array $attributes = []): bool
    {
        $this->status = $status;
        return $this->update($attributes);
    }
}
