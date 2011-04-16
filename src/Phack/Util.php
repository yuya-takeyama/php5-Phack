<?php
namespace Phack;

/**
 * Utitlity methods for Phack.
 */
class Util
{
    /**
     * Converts from snake_case to CamelCase.
     *
     * @param  string $snakeCaseStr snake_case_string.
     * @return string               CamelCaseString.
     */
    public static function toCamelCase($snakeCaseStr)
    {
        $result = '';
        $words = \explode('_', $snakeCaseStr);
        foreach ($words as $word) {
            $result .= \ucfirst($word);
        }
        return $result;
    }

    /**
     * Parses a query string into hash var.
     *
     * @param  string $query Query string.
     * @return array         Parsed query hash.
     */
    public static function parseQuery($query)
    {
        $result = array();
        $parts  = \preg_split('/[&;]/', $query);
        foreach ($parts as $part) {
            list($key, $value) = \explode('=', $part, 2);
            $result[\urldecode($key)] = \urldecode($value);
        }
        return $result;
    }
}
