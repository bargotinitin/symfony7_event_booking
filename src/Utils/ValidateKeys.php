<?php

namespace App\Utils;

class ArrayHelper
{
    public static function validateRequiredFields(array $array, array $requiredKeys): bool
    {
        foreach ($requiredKeys as $key) {
            if (!array_key_exists($key, $array) || $array[$key] === '' || is_null($array[$key])) {
                return false;
            }
        }
        return true;
    }
}
