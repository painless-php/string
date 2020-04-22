<?php

namespace Nonetallt\String;

use Nonetallt\String\Language\English;
use Nonetallt\String\Exception\TypeConversionException;

class Str
{
    CONST NUMBERS = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

    CONST LATIN_ALPHABET = [
        'a',
        'b',
        'c',
        'd',
        'e',
        'f',
        'g',
        'h',
        'i',
        'j',
        'k',
        'l',
        'm',
        'n',
        'o',
        'p',
        'q',
        'r',
        's',
        't',
        'u',
        'v',
        'w',
        'x',
        'y',
        'z',
    ];

    /**
     * Check if string starts with one of the given starts
     *
     */
    public static function startsWith(string $subject, string ...$starts) : bool
    {
        foreach($starts as $start) {
            $subjectStart = mb_substr($subject, 0, mb_strlen($start));
            if($subjectStart === $start) return true;
        }

        return false;
    }

    /**
     * Check if string ends with one of the given endings
     *
     */
    public static function endsWith(string $subject, string ...$ends) : bool
    {
        foreach($ends as $index => $end) {
            $subjectEnd = mb_substr($subject, mb_strlen($subject) - mb_strlen($end));
            if($subjectEnd === $end) return true;
        }

        return false;
    }

    /**
     * Remove prefix from beginning of subject string
     *
     */
    public static function removePrefix(string $subject, string $prefix) : string
    {
        if(static::startsWith($subject, $prefix)) {
            $subject = mb_substr($subject, mb_strlen($prefix));
        }

        return $subject;
    }

    /**
     * Remove a suffix from end of the subject string
     *
     */
    public static function removeSuffix(string $subject, string $suffix) : string
    {
        if(static::endsWith($subject, $suffix)) {
            $len = mb_strlen($subject) - mb_strlen($suffix);
            $subject = mb_substr($subject, 0, $len);
        }

        return $subject;
    }

    /**
     * Check if string starts with whitespace character
     *
     */
    public static function startsWithWhitespace(string $subject) : bool
    {
        return preg_match('|^\s+|', $subject) === 1;
    }


    /**
     * Explode string with multiple delimiters
     *
     */
    public static function explodeMultiple(string $subject, string ...$delimiters) : array
    {
        /* Get first delimiter */
        $first = $delimiters[0];

        /* Replace all delimiters on the subject with the first one */
        foreach($delimiters as $delimiter) {
            $subject = str_replace($delimiter, $first, $subject);
        }

        return mb_split($first, $subject);
    }


    /**
     * Remove repeating occurences of character within subject string 
     *
     */
    public static function removeRecurring(string $subject, string $character) : string
    {
        if(mb_strlen($character) !== 1) {
            $message = "Given character must be a string with a length of 1 character. '$character' given.";
            throw new \InvalidArgumentException($message) ;
        } 

        $indexesToRemove = [];
        $lastChar = '';

        for($n = 0; $n < mb_strlen($subject); $n++) {
            $currentChar = mb_substr($subject, $n, 1);
            if($currentChar === $lastChar && $currentChar === $character) $indexesToRemove[] = $n -1;
            $lastChar = $currentChar;
        }

        foreach($indexesToRemove as $index => $pos) {
            /* Index equals the number of indexes removed, 
                adjust position by the amount of characters that were removed 
             */
            $subject = substr_replace($subject, '', $pos - $index, 1);
        }

        return $subject;
    }


    /**
     * Extract a substring from the subject string
     *
     */
    public static function splice(string &$subject, int $start, int $length = null) : string
    {
        if(is_null($length)) $length = mb_strlen($subject);

        $result = mb_substr($subject, $start, $length);
        $subject =  mb_substr($subject, 0, $start) . mb_substr($subject, $start + $length);

        return $result;
    }

    /**
     * Get the part of string after first occurence of another string
     *
     */
    public static function after(string $subject, string $after) : string
    {
        $pos = mb_strpos($subject, $after);

        /* Return subject string if after is not found */
        if($pos === false) return $subject;

        return mb_substr($subject, $pos + mb_strlen($after));
    }


    /**
     * Get the part of string before first occurence of another string
     *
     */
    public static function before(string $subject, string $before) : string
    {
        $pos = mb_strpos($subject, $before);

        /* Return subject string if after is not found */
        if($pos === false) return $subject;

        return mb_substr($subject, 0, $pos);
    }

    /**
     * Check if subject string contains another string
     *
     */
    public static function contains(string $subject, string $another) : bool
    {
        return mb_strpos($subject, $another) !== false;
    }

    /**
     * Get the difference between two strings
     *
     */
    public static function diff(string $subject, string $another) : array
    {
        $diff = [];

        for($n = 0; $n < mb_strlen($subject); $n++) {
            $s1 = mb_substr($subject, $n, 1);
            $s2 = mb_substr($another, $n, 1);

            if($s1 !== $s2) $diff[$n] = "'$s1' !== '$s2'";
        }

        return $diff;
    }

    /**
     * Check if the given value can be cast to string
     *
     */
    public static function isConvertable($value) : bool
    {
        return is_null($value) || 
            is_scalar($value) || 
            (is_object($value) && method_exists($value, '__toString'));
    }

    /**
     * Convert given value into string
     *
     * @throws TypeConversionException
     *
     */
    public static function convertFrom($value) : string
    {
        if(! static::isConvertable($value)) {
            $type = is_object($value) ? get_class($value) : gettype($value);
            $msg = "Given value of type $type is not str convertable";
            throw new TypeConversionException($msg);
        }

        return (string)$value;
    }

    /**
     * Convert string into the specified type
     *
     * @throws TypeConversionException
     *
     */
    public static function convertTo(string $value, TypeConverterInterface $converter)
    {
        return $converter->convert($value);
    }

    /**
     * Describe the given value as a string
     *
     */
    public static function describe($value) : string
    {
        if(is_bool($value)) {
            return $value ? 'true' : false;
        }

        if(is_null($value)) {
            return 'null';
        }

        if(is_object($value)) {
            return get_class($value);
        }

        if(is_array($value)) {
            return 'array';
        }

        if(is_resource($value)) {
            return 'resource';
        }

        if(is_callable($value)) {
            return 'callable';
        }

        return (string)$value;
    }

    /**
     * Generates a cryptographically secure random string
     *
     */
    public static function random(int $length, $characters = null) : string
    {
        if($length < 1) {
            $msg = 'length must be at least 1';
            throw new \InvalidArgumentException($msg);
        }

        if($characters === null) {
            $characters = static::alphanumeric(true);
        }

        if(is_string($characters)) {
            $characters = str_split($characters);
        }

        if(! is_array($characters)) {
            $msg = "characters must be either a string or an array";
            throw new \InvalidArgumentException($msg);
        }

        /* Last index */
        $max = count($characters) -1;
        $result = '';

        while(mb_strlen($result) < $length) {
            $result .= $characters[random_int(0, $max)];
        }

        return $result;
    }

    /**
     * Get all characters in the latin alphabet
     *
     */
    public static function latinAlphabet(bool $includeUpper = true) : array
    {
        $characters = static::LATIN_ALPHABET;

        if($includeUpper) {
            $uc = [];
            foreach($characters as $character) {
                $uc[] = strtoupper($character);
            }
            $characters = array_merge($characters, $uc);
        }

        return $characters;
    }

    /**
     * Get an array containing alphanumeric characters
     *
     */
    public static function alphanumeric(bool $includeUpper = true, array $characters = null) : array
    {
        if($characters === null) {
            $characters = static::latinAlphabet($includeUpper);
        }

        return array_merge($characters, static::numbers());
    }

    /**
     * Get all numeric characters
     *
     */
    public static function numbers() : array
    {
        return static::NUMBERS;
    }
}
