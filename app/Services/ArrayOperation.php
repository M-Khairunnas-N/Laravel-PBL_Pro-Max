<?php

namespace App\Services;

class ArrayOperation
{
    /**
     * compare each same arary key value and calculate based operator (-, +, *, or /) given to  that elements
     * @param array $arr_1
     * @param array $arr_2
     * @param string $operator
     * @return array
     */
    public static function calculateElements(array $arr_1, array $arr_2, string $operator): array
    {
        return array_combine(
            array_keys($arr_1),
            array_map(function ($value1, $value2) use($operator) {

                if (!is_numeric($value1) && !is_numeric($value2)) {
                    throw new \InvalidArgumentException('argument arr_1 and arr_2 is just float, double, and integer allowed');
                }

                $result = match ($operator) {
                    '-' => $value1 - $value2,
                    '+' => $value1 + $value2,
                    '*' => $value1 * $value2,
                    '/' => $value1 / $value2,
                    default => throw new \InvalidArgumentException('Invalid operator provided, operator must -, +, *, and /'),
                };

                if (is_float($result) || is_double($result)) {
                    return round($result, 3);
                }

                return $result;
            }, $arr_1, $arr_2)
        );
    }


    /**
     * remove unwanted key and value in array
     * @param array $array
     * @param array $unwantedKeys
     * @return array
     */
    public static function removeKeys(array $array, array $unwantedKeys): array
    {
        return array_diff_key($array, array_flip($unwantedKeys));
    }
}
