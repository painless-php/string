# Nonetallt\String\Str



## Methods

```php
/**
* Prepend a given prefix to string. Prefix is not prepended if the given
* subject already has that prefix.
*
*/
public static function addPrefix(string $subject, string $prefix);

/**
* Append a given suffix to string. Suffix is not appended if the given
* subject already has that suffix.
*
*/
public static function addSuffix(string $subject, string $suffix);

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
* @throws TypeConversionException
*
*/
public static function convertFrom($value) : string;

/**
* Convert string into the specified type
*
* @throws TypeConversionException
*
*/
public static function convertTo(string $value, $converter);

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
* Remove all specified sequences from the beginning of the subject
*
* While removePrefix only removes one prefix, this method will keep
* removing given prefixes until there are no prefixes at the beginning of
* the string.
*
*/
public static function removeLeading(string $subject, string ...$prefixes) : string;

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
* Remove all specified sequences from the end of the subject
*
* While removeSuffix only removes one suffix, this method will keep
* removing given suffixes until there are no suffixes at the end of the
* string.
*
*/
public static function removeTrailing(string $subject, string ...$suffixes) : string;

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

/**
 * Convert a given string into snake case.
 *
 */
public static function toSnakeCase(string $subject, array $convertedCharacters = ['-']) : string;


/**
 * Convert a given string into kebab case.
 *
 */
public static function toKebabCase(string $subject, array $convertedCharacters = ['-']) : string;
```
