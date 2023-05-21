<?php

namespace PainlessPHP\String\Contract;

use PainlessPHP\String\Exception\StringTypeConversionException;

/**
 * Converts strings into the given type
 *
 */
interface StringTypeConverterInterface
{
    /**
     * Attempt to convert a given value
     *
     * @throws StringTypeConversionException
     *
     */
    public function convert(string $value);
}
