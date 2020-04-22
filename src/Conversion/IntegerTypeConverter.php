<?php

namespace Nonetallt\String\Conversion;

use Nonetallt\String\Contract\TypeConverterInterface;
use Nonetallt\String\Exception\TypeConversionException;

class IntegerTypeConverter implements TypeConverterInterface
{
    public function convert(string $value) : int
    {
        if(is_numeric($value)) {
            return intval($value);
        }

        throw TypeConversionException::fromConversion($this, $value);
    }
}
