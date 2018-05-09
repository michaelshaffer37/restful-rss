<?php

namespace App\Contracts\Data;

/**
 * Interface MongoClientInterface
 *
 * @package App\Contracts\Data
 */
interface MongoClientInterface
{
    /**
     * Select a database.
     *
     * @see \MongoDB\Database::__construct() for supported options
     *
     * @param string $databaseName Name of the database to select
     * @param array  $options Database constructor options
     *
     * @return \MongoDB\Database
     * @throws \MongoDB\Exception\InvalidArgumentException for parameter/option parsing errors
     */
    public function selectDatabase($databaseName, array $options = []);
}
