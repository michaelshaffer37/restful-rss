<?php

namespace App\Tests\Unit\Support;

use App\Support\Exceptions\InvalidJsonException;
use App\Support\Json;
use App\Tests\TestCase;

/**
 * Class JsonTest
 *
 * @package App\Tests\Unit\Support
 */
class JsonTest extends TestCase
{
    /**
     *  Verify that the json is decoding arrays correctly.
     */
    public function testDecodeArrayToArray()
    {
        $validJson = '["first","second",3,true,false,null]';

        $validArray = ['first', 'second', 3, true, false, null];

        $methodDecode = Json::decode($validJson);

        $this->assertEquals($validArray, $methodDecode);
    }

    /**
     * Verify that the json decoding is converting json objects into associative arrays,
     * as they can be easily converted implicitly.
     */
    public function testDecodeObjectToAssociativeArray()
    {
        $validJson = '{"first":2,"second":4}';

        $validArray = ['first' => 2, 'second' => 4];

        $methodDecode = Json::decode($validJson);

        $this->assertEquals($validArray, $methodDecode);
    }

    /**
     *  Validate the that encode method is correctly encoding associative arrays as json objects.
     */
    public function testEncodeMethod()
    {
        $validJson = '{"first":{"a":1,"b":2},"second":{"c":2,"d":4}}';
        $validPHP = ['first' => ['a' => 1, 'b' => 2], 'second' => ['c' => 2, 'd' => 4]];

        $methodEncode = Json::encode($validPHP);

        $this->assertEquals($validJson, $methodEncode);
    }

    /**
     * Validate the that encode method is correctly encoding associative arrays as json objects
     * so the keys are retained.
     */
    public function testEncodeAssociativeArrayToObject()
    {
        $validJson = '{"first":"one","second":"two"}';
        $validPHP = ['first' => 'one', 'second' => 'two'];

        $methodEncode = Json::encode($validPHP);

        $this->assertEquals($validJson, $methodEncode);
    }

    /**
     * Validate the simple php arrays are being encoded as arrays.
     */
    public function testEncodeSimpleArrayToArray()
    {
        $validJson = '["one","two"]';
        $validPHP = ['one', 'two'];

        $methodEncode = Json::encode($validPHP);

        $this->assertEquals($validJson, $methodEncode);
    }

    /**
     *  Validate the invalid json throws the InvalidJsonException Exception.
     */
    public function testInvalidDecode()
    {
        $invalidJson = 'test_string';
        try {
            Json::decode($invalidJson);
        } catch (InvalidJsonException $e) {
            $this->assertInstanceOf(InvalidJsonException::class, $e);
        }
    }

    /**
     * Verify that is valid json "False" (caps not valid for booleans) does not decode.
     */
    public function testBadJsonDecode()
    {
        $invalidJson = '{"test":False}';
        try {
            Json::decode($invalidJson);
        } catch (InvalidJsonException $e) {
            $this->assertInstanceOf(InvalidJsonException::class, $e);
        }
    }

    /**
     * Verify the null is never returned by the json decode method.
     * Even though "null" is technically valid json.
     */
    public function testBadNullJsonDecode()
    {
        $invalidJson = 'null';
        try {
            Json::decode($invalidJson);
        } catch (InvalidJsonException $e) {
            $this->assertInstanceOf(InvalidJsonException::class, $e);
        }
    }

    /**
     * Verify that bool types that have implicit conversion to string don't json decode.
     */
    public function testDecodeInvalidInputType1Decode()
    {
        $invalidJson = false;

        self::expectException(
            InvalidJsonException::class
        );

        Json::decode($invalidJson);
    }

    /**
     * Verify that bool types that have implicit conversion to string don't json decode.
     */
    public function testDecodeInvalidInputType2Decode()
    {
        $invalidJson = true;

        self::expectException(
            InvalidJsonException::class
        );

        Json::decode($invalidJson);
    }

    /**
     * Verify that numeric types that have implicit conversion to string don't json decode.
     */
    public function testDecodeInvalidInputType3Decode()
    {
        $invalidJson = 125.5;

        self::expectException(
            InvalidJsonException::class
        );

        Json::decode($invalidJson);
    }
}
