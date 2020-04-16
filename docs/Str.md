# Nonetallt\String\Str



## Methods

```php
/**
* Get the part of string after first occurence of another string
*
*/
public static function after(string $subject, string $after) : string;

/**
* Get an array containing alphanumeric characters
*
*/
public static function alphanumeric(bool $includeUpper = true, array $characters = null) : array;

/**
* Get the part of string before first occurence of another string
*
*/
public static function before(string $subject, string $before) : string;

/**
* Check if subject string contains another string
*
*/
public static function contains(string $subject, string $another) : bool;

/**
* Convert given value into string
*
*/
public static function convert($value) : string;

/**
* Describe the given value as a string
*
*/
public static function describe($value) : string;

/**
* Get the difference between two strings
*
*/
public static function diff(string $subject, string $another) : array;

/**
* Check if string ends with one of the given endings
*
*/
public static function endsWith(string $subject, string ...$ends) : bool;

/**
* Explode string with multiple delimiters
*
*/
public static function explodeMultiple(string $subject, string ...$delimiters) : array;

/**
* Check if the given value can be cast to string
*
*/
public static function isConvertable($value) : bool;

/**
* Get all characters in the latin alphabet
*
*/
public static function latinAlphabet(bool $includeUpper = true) : array;

/**
* Get all numeric characters
*
*/
public static function numbers() : array;

/**
* Generates a cryptographically secure random string
*
*/
public static function random(int $length, $characters = null) : string;

/**
* Remove prefix from beginning of subject string
*
*/
public static function removePrefix(string $subject, string $prefix) : string;

/**
* Remove repeating occurences of character within subject string
*
*/
public static function removeRecurring(string $subject, string $character) : string;

/**
* Remove a suffix from end of the subject string
*
*/
public static function removeSuffix(string $subject, string $suffix) : string;

/**
* Extract a substring from the subject string
*
*/
public static function splice(string &$subject, int $start, int $length = null) : string;

/**
* Check if string starts with one of the given starts
*
*/
public static function startsWith(string $subject, string ...$starts) : bool;

/**
* Check if string starts with whitespace character
*
*/
public static function startsWithWhitespace(string $subject) : bool;
```
