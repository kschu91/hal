<?php
namespace Aeq\Hal\Utils;

class ArrayUtils
{
    /**
     * @param array $arr
     * @return bool
     */
    public static function isNumericArray(array $arr)
    {
        foreach (array_keys($arr) as $a) {
            if (!is_int($a)) {
                return false;
            }
        }
        return true;
    }
}
