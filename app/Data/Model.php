<?php

namespace App\Data;

use App\Contracts\Data\ModelInterface;
use App\Data\Concerns\ArrayAccessable;
use App\Data\Concerns\HasAttributes;
use App\Support\Exceptions\InvalidJsonException;
use App\Support\Json;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use MongoDB\Database;

/**
 * Class Model
 *
 * @package App\Data
 */
abstract class Model implements ModelInterface
{
    use HasAttributes,
        ArrayAccessable;

    /**
     * The key attribute name for the model.
     *
     * @var string
     */
    protected $primaryKey = '_id';

    /**
     * The MongoDb Collection used for CRUD in this model
     *
     * @var \MongoDB\Collection
     */
    protected $collection;

    /**
     * The mongo db client to use for resolving the specific collection of this model
     *
     * @var \MongoDB\Database
     */
    protected static $database;

    /**
     * Create a new Data Model instance.
     *
     * @param  array $attributes
     *
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        $this->collection = static::$database->selectCollection(
            $this->getCollectionName()
        );

        $this->fill($attributes);
    }

    /**
     * Fill the model with an array of attributes.
     *
     * @param  array $attributes
     *
     * @return $this
     */
    public function fill(array $attributes): ModelInterface
    {
        foreach ($attributes as $key => $value) {
            $this->setAttribute($key, $value);
        }

        return $this;
    }

    /**
     * Save the current state of the model to the db.
     *
     * @return bool
     */
    public function save(): bool
    {
        $update = $this->collection->updateOne(
            [
                $this->getKeyName() => $this->getKey(),
            ],
            [
                '$set' => $this->getAttributes()
            ],
            ['upsert' => true]
        );

        return $update->isAcknowledged();
    }

    /**
     * @return ModelInterface
     */
    public function find($id, $attributes = []): ModelInterface
    {
        $response = $this->collection->findOne(array_merge([ $this->getKeyName() => $id], $attributes));
        return $this->newInstance((array) $response);
    }

    public function all($attributes = []): Collection
    {
        return collect([]);
    }

    /**
     * Get the primary key for the model.
     *
     * @return string
     */
    public function getKeyName(): string
    {
        return $this->primaryKey;
    }

    /**
     * Get the value of the model's primary key.
     *
     * @return mixed
     */
    public function getKey()
    {
        return $this->getAttribute($this->getKeyName());
    }

    /**
     *  Return the name of the collection this model is associated with.
     *
     * @return string
     */
    public function getCollectionName(): string
    {
        return Str::snake(Str::plural(class_basename($this)));
    }

    /**
     * Convert the model instance to JSON.
     *
     * @param  int $options
     *
     * @return string
     *
     * @throws InvalidJsonException
     */
    public function toJson($options = 0)
    {
        return Json::encode($this->jsonSerialize(), $options);
    }

    /**
     * Convert the object into something JSON serializable.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * Convert the model instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->getAttributes();
    }

    /**
     * Convert the model to its string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }

    /**
     * @inheritdoc
     */
    public static function setDatabase(Database $database): void
    {
        static::$database = $database;
    }

    protected function newInstance(array $attributes = [])
    {
        return new static($attributes);
    }
}
