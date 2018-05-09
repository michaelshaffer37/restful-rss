<?php

namespace App\Support;

use App\Support\Exceptions\InvalidJsonException;

/**
 * Class Json
 *
 * @package App\Support
 */
class Json
{
    /**
     * Decode the given value and throw an error is anything goes wrong.
     *
     * @param      $json
     * @param bool $assoc
     * @param int  $depth
     * @param int  $options
     *
     * @return mixed
     *
     * @throws InvalidJsonException
     */
    public static function decode($json, $assoc = true, $depth = 512, $options = 0)
    {
        $value = is_string($json) ? json_decode($json, $assoc, $depth, $options) : null;
        self::throwLastError('decode', $value);
        return $value;
    }

    /**
     * Encode the given value and throw an error is anything goes wrong.
     *
     * @param     $value
     * @param int $options
     * @param int $depth
     *
     * @return string
     *
     * @throws InvalidJsonException
     */
    public static function encode($value, $options = 0, $depth = 512)
    {
        $json = json_encode($value, $options, $depth);
        self::throwLastError('encode', $json);
        return $json;
    }

    /**
     * If any of the obscure error cases occurred make sure that we throw an error.
     *
     * @param string $method
     * @param mixed  $value
     *
     * @return void
     *
     * @throws InvalidJsonException
     */
    public static function throwLastError($method, $value)
    {
        //Get the last JSON error.
        $jsonError = json_last_error();

        //If an error exists.
        if ($jsonError != JSON_ERROR_NONE) {
            $error = "Could not {$method} JSON. ";

            //Use a switch statement to figure out the exact error.
            $error .= json_last_error_msg();

            throw new InvalidJsonException($error);
        }

        // Catch All others
        if ((is_null($value) || $value === false)
            || (is_null($jsonError) && $jsonError == JSON_ERROR_NONE)) {
            throw new InvalidJsonException("Failed to {$method} JSON String.");
        }
        // We didn't find any errors to throw :-)
    }
}
