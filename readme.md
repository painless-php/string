# string

String helper functionality for PHP

## Public API

#### Core

* [Str](docs/Str.md)

#### Exception

* PainlessPHP\String\Exception\TypeConversionException

## TODO

* update required php version (can check with package-boilerplate-core eventually)

* method overview (as markdown table? in readme)

* test bench for current startsWith vs inbuilt str_starts_with
    * use inbuilt method if it's faster

* fix random tests sometimes failing

* afterFirst (rename after)
* afterLast
* beforeFirst (rename before)
* beforeLast
* findWordContaining
* suffix and prefix "once" parameter?
* trimLines
* editLines

- generate ide helper for StrBuilder so that magic methods are exposed to IDE
