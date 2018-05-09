<?php

namespace App\Tests\Unit\Data;

use App\Contracts\Data\ModelInterface;
use App\Data\Model;
use App\Tests\TestCase;
use MongoDB\Collection;
use MongoDB\Database;
use MongoDB\UpdateResult;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * Class FeedTest
 *
 * @package App\Tests\Unit\Data
 */
class ModelTest extends TestCase
{
    protected $model;

    public function setUp()
    {
        parent::setUp();

        $mockDb = $this->mockDatabase();
        Model::setDatabase($mockDb);

        $this->model = $this->getMockForAbstractClass(Model::class);
    }

    public function testFill()
    {
        $attributes = ['first' => 1, 'second' => 'hello'];

        $returnedModel = $this->model->fill($attributes);

        $this->assertTrue(
            $this->model->fill($attributes) instanceof ModelInterface,
            'the fill method should return a model instance'
        );

        $this->assertSame(
            $this->model,
            $returnedModel,
            'the fill method should be chainable'
        );

        foreach ($attributes as $key => $value) {
            $this->assertTrue(
                isset($this->model->$key),
                'the model has all of the given attributes accessible on it'
            );
            $this->assertSame(
                $value,
                $this->model->$key,
                'the value of each attribute should be the same as the value in the array'
            );
        }
    }

    public function testSave()
    {
        $updateResult = $this->createMock(UpdateResult::class);
        $updateResult->method('isAcknowledged')->willReturn(true);
        $mockCollection = $this->mockCollection();

        $mockCollection->expects($this->once())
            ->method('updateOne')
            ->with(
                $this->anything(),
                $this->anything(),
                $this->callback(function ($subject) {
                    return array_key_exists('upsert', $subject) && $subject['upsert'];
                })
            )
            ->willReturn($updateResult);

        $mockDb = $this->mockDatabase($mockCollection);

        Model::setDatabase($mockDb);

        $testModel = $this->getMockForAbstractClass(Model::class);

        $testModel->first = 'yes';

        $this->assertTrue(
            $testModel->save(),
            'The model should return true on successfully saving.'
        );
        // TODO: Figure out what to test here.

    }

    public function testFind()
    {
        $this->markTestIncomplete('Needs Further Testing');
    }

    public function testAll()
    {
        $this->markTestIncomplete('Needs Further Testing');
    }

    /**
     * Build a Mock of the MongoDb Database class
     *
     * @return MockObject|\MongoDb\Database
     */
    protected function mockDatabase($collection = null)
    {
        $mock = $this->createMock(Database::class);

        $mockCollection = is_null($collection) ? $this->mockCollection() : $collection;

        $mock->method('selectCollection')->willReturn($mockCollection);

        return $mock;
    }

    /**
     * Build a Mock of the MongoDb Database class
     *
     * @return MockObject|\MongoDb\Collection
     */
    protected function mockCollection()
    {
        return $this->createMock(Collection::class);
    }
}
