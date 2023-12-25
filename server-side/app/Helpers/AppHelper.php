<?php

namespace App\Helpers;

use Exception;
use InvalidArgumentException;
use RuntimeException;

class AppHelper
{
    /**
     * This function is used to get uuid example: 1b9d6bcd-bbfd-4b2d-9b5d-ab8dfbbd4bed
     * @return string
     * @throws Exception
     */
    public static function getUuid(): string
    {
        return \Ramsey\Uuid\Uuid::uuid4()->toString();
    }

    /**
     * This function is used to get random number code example: 123456
     * @param int $length
     * @return string
     * @throws Exception
     */
    public static function getRandomNumberCode(int $length = 6): string
    {
        $codeArr = array_map(function($a) {
            return random_int(0, 9);
        }, array_fill(0,$length,0));

        return implode('', $codeArr);
    }

    /**
     * This function is used to get random mixed code example: 1B9d6bD
     * @param int $length
     * @return string
     * @throws Exception
     */
    public static function getRandomMixedCode(int $length = 6): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }

    // Function to convert class of given object
    public static function castObjectTo($object, $final_class)
    {
        if (empty($object)) {
            return new $final_class();
        }

        if (!is_object($object)) {
            throw new InvalidArgumentException('The provided object must be an instance of a class.');
        }

        $object_class = get_class($object);

        if ($object_class === $final_class) {
            return $object;
        }

        if (!is_subclass_of($object_class, $final_class)) {
            throw new InvalidArgumentException(sprintf('Cannot cast object of class %s to %s.', $object_class, $final_class));
        }

        $serialized_object = serialize($object);
        $casted_object = unserialize(sprintf('O:%d:"%s"%s', strlen($final_class), $final_class, strstr(strstr($serialized_object, '"'), ':')));

        if ($casted_object === false) {
            throw new RuntimeException(sprintf('Failed to cast object of class %s to %s.', $object_class, $final_class));
        }

        return $casted_object;
    }

}
