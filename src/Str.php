<?php

namespace PainlessPHP\String;

use InvalidArgumentException;
use PainlessPHP\String\Exception\StringTypeConversionException;
use PainlessPHP\String\Conversion\StringTypeConversionMapping;
use PainlessPHP\String\Contract\StringTypeConverterInterface;
use PainlessPHP\String\Exception\StringSearchException;

class Str
{
    /**
     * Check if string starts with one of the given starts
     *
     */
    public static function startsWith(string $subject, string ...$starts) : bool
    {
        foreach($starts as $start) {
            if(str_starts_with($subject, $start)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if string ends with one of the given endings
     *
     */
    public static function endsWith(string $subject, string ...$ends) : bool
    {
        foreach($ends as $end) {
            if(str_ends_with($subject, $end)) {
                return true;
            }
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
     * @return array<string>
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
            throw new InvalidArgumentException($message) ;
        }

        $indexesToRemove = [];
        $lastChar = '';

        for($n = 0; $n < mb_strlen($subject); $n++) {
            $currentChar = mb_substr($subject, $n, 1);
            if($currentChar === $lastChar && $currentChar === $character) {
                $indexesToRemove[] = $n - 1;
            }
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
        if($length === null) {
            $length = mb_strlen($subject);
        }

        $result = mb_substr($subject, $start, $length);
        $subject =  mb_substr($subject, 0, $start) . mb_substr($subject, $start + $length);

        return $result;
    }

    /**
     * Get the part of string after first occurence of another string
     *
     */
    public static function afterFirst(string $subject, string $after) : string
    {
        $pos = mb_strpos($subject, $after);

        /* Return subject string if after is not found */
        if($pos === false) {
            return $subject;
        }

        return mb_substr($subject, $pos + mb_strlen($after));
    }


    /**
     * Get the part of string before first occurence of another string
     *
     */
    public static function beforeFirst(string $subject, string $before) : string
    {
        $pos = mb_strpos($subject, $before);

        /* Return subject string if after is not found */
        if($pos === false) {
            return $subject;
        }

        return mb_substr($subject, 0, $pos);
    }

    /**
     * Check if subject string contains another string
     *
     */
    public static function contains(string $subject, string $another) : bool
    {
        return str_contains($subject, $another);
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

            if($s1 !== $s2) {
                $diff[$n] = "'$s1' !== '$s2'";
            }
        }

        return $diff;
    }

    /**
     * Check if the given value can be cast to string
     *
     * @param mixed $value
     *
     */
    public static function isConvertable($value) : bool
    {
        return $value === null ||
            is_scalar($value) ||
            (is_object($value) && method_exists($value, '__toString'));
    }

    /**
     * Convert given value into string
     *
     * @throws StringTypeConversionException
     *
     */
    public static function convertFrom($value) : string
    {
        if(! static::isConvertable($value)) {
            $type = get_debug_type($value);
            $msg = "Given value of type $type is not str convertable";
            throw new StringTypeConversionException($msg);
        }

        return (string)$value;
    }

    /**
     * Convert string into the specified type
     *
     * @throws StringTypeConversionException
     *
     */
    public static function convertTo(string $value, $converter)
    {
        if(is_string($converter)) {

            if($converter === 'string') {
                return $value;
            }

            $class = StringTypeConversionMapping::MAPPING[$converter] ?? null;
            if($class === null) {
                $msg = "Converter matching alias '$converter' not found";
                throw new StringTypeConversionException($msg);
            }
            $converter = new $class();
        }

        $interface = StringTypeConverterInterface::class;

        if(in_array($interface, class_implements($converter))) {
            return $converter->convert($value);
        }

        $msg = "Converter must be either a string or an instance of $interface";
        throw new StringTypeConversionException($msg);

    }

    /**
     * Describe the given value as a string
     *
     */
    public static function describe($value) : string
    {
        if(is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        if($value === null) {
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
    public static function random(int $length, array|string $characters = null) : string
    {
        if($length < 1) {
            $msg = 'length must be at least 1';
            throw new InvalidArgumentException($msg);
        }

        if($characters === null) {
            $characters = static::alphanumeric(true);
        }

        if(is_string($characters)) {
            $characters = mb_str_split($characters);
        }

        if(! is_array($characters)) {
            $msg = "characters must be either a string or an array";
            throw new InvalidArgumentException($msg);
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
    public static function latinAlphabet(bool $includeUpper = false) : array
    {
        $characters = range('a', 'z');

        if($includeUpper) {
            $characters = [...$characters, ...range('A', 'Z')];
        }

        return $characters;
    }

    /**
     * Get an array containing alphanumeric characters
     *
     */
    public static function alphanumeric(bool $includeUpper = false, array|string $characters = null) : array
    {
        if($characters === null) {
            $characters = static::latinAlphabet($includeUpper);
        }

        if(is_string($characters)) {
            $characters = mb_str_split($characters);
        }

        return [...$characters, ...range(0, 9)];
    }

    /**
     * Prepend a given prefix to string. Prefix is not prepended if the given
     * subject already has that prefix.
     *
     */
    public static function addPrefix(string $subject, string $prefix) : string
    {
        if(! static::startsWith($subject, $prefix)) {
            $subject = $prefix . $subject;
        }

        return $subject;
    }

    /**
     * Append a given suffix to string. Suffix is not appended if the given
     * subject already has that suffix.
     *
     */
    public static function addSuffix(string $subject, string $suffix) : string
    {
        if(! static::endsWith($subject, $suffix)) {
            $subject .= $suffix;
        }

        return $subject;
    }

    /**
     * Remove all specified sequences from the beginning of the subject
     *
     * While removePrefix only removes one prefix, this method will keep
     * removing given prefixes until there are no prefixes at the beginning of
     * the string.
     *
     */
    public static function removeLeading(string $subject, string ...$prefixes) : string
    {
        while(static::startsWith($subject, ...$prefixes)) {

            foreach($prefixes as $prefix) {
                $subject = static::removePrefix($subject, $prefix);
            }
        }

        return $subject;
    }

    /**
     * Remove all specified sequences from the end of the subject
     *
     * While removeSuffix only removes one suffix, this method will keep
     * removing given suffixes until there are no suffixes at the end of the
     * string.
     *
     */
    public static function removeTrailing(string $subject, string ...$suffixes) : string
    {
        while(static::endsWith($subject, ...$suffixes)) {

            foreach($suffixes as $suffix) {
                $subject = static::removeSuffix($subject, $suffix);
            }
        }

        return $subject;
    }

    /**
     * Convert a given string into snake case.
     *
     */
    public static function toSnakeCase(string $subject, array $convertedCharacters = ['-']) : string
    {
        $str = '';

        foreach(mb_str_split($subject) as $index => $char) {

            if($index !== 0 && $index < strlen($subject) - 1 && (ctype_upper($char) || in_array($char, $convertedCharacters))) {
                $str .= '_';
            }

            $str .= $char;
        }

        return strtolower($str);
    }

    /**
     * Convert a given string into kebab case.
     *
     */
    public static function toKebabCase(string $subject, array $convertedCharacters = ['_']) : string
    {
        $str = '';

        foreach(mb_str_split($subject) as $index => $char) {

            if($index !== 0 && $index < strlen($subject) - 1 && (ctype_upper($char) || in_array($char, $convertedCharacters))) {
                $str .= '-';
            }

            $str .= $char;
        }

        return strtolower($str);
    }

    /**
     * Get all characters in the string as an array
     *
     */
    public static function characters(string $subject, bool $unique = false) : array
    {
        $characters = mb_str_split($subject);

        if($unique) {
            // Do not preserve keys for filtered result
            $characters = array_values(array_unique($characters));
        }

        return $characters;
    }

    /**
     * Find the a word that contains the given search in the given string
     *
     * @throws StringSearchException
     *
     */
    public static function findFirstWordContaining(string $subject, string $search) : string
    {
        foreach(preg_split('|\s+|', $subject) as $word) {

            if(self::contains($word, $search)) {
                return $word;
            }
        }

        $msg = "Could not find word containing '$search' in subject '$subject'";
        throw new StringSearchException($msg);
    }

    /**
     * Find all words that contains the given search in the given string
     *
     */
    public static function findAllWordsContaining(string $subject, string $search) : array
    {
        $result = [];

        foreach(preg_split('/\s+/', $subject) as $word) {
            if(self::contains($word, $search)) {
                $result[] = $word;
            }
        }

        return $result;
    }
}
