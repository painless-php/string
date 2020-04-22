<?php

namespace Nonetallt\String\Contract;

use Nonetallt\String\Exception\TypeConversionException;

/**
 * Converts strings into the given type
 *
 */
interface TypeConverterInterface
{
    /**
     * Attempt to convert a given value
     *
     * @throws TypeConversionException
     *
     */
    public function convert(string $value);
}
