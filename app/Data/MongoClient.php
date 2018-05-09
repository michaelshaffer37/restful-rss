<?php

namespace App\Data;

use App\Contracts\Data\MongoClientInterface;
use MongoDB\Client;

/**
 * Class MongoClient
 *
 * @package App\Data
 */
class MongoClient extends Client implements MongoClientInterface
{
}
