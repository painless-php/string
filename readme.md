# string

String helper functionality for PHP

## Installation

```
composer require painless-php/string
```

## Public API

#### Core

* [Str](doc/Str.md)
* [StrBuilder](doc/StrBuilder.md)

#### Exception

* `PainlessPHP\String\Exception\StringSearchException`
* `PainlessPHP\String\Exception\StringTypeConversionException`

## Development

#### Dynamic method doc generation

Use `php bin/generate_builder_docblock.php` to generate phpdocumentor docblocks
for the methods that can be called dynamically from StrBuilder.

#### TODO

* generate Str method list in docs with a markdown table
* bump required php version to 8.4 and add `$builder->str` getter for the result string

* methods
    * findFirstLineContaining
    * findLinesContaining
    * findLastLineContaining
    * trimLines
    * editLines
