<?php

namespace Nonetallt\String\Conversion;

use Nonetallt\String\Contract\TypeConverterInterface;
use Nonetallt\String\Exception\TypeConversionException;

class FloatTypeConverter implements TypeConverterInterface
{
    public function convert(string $value) : float
    {
        if(is_numeric($value)) {
            return floatval($value);
        }

        throw TypeConversionException::fromConversion($this, $value);
    }
}
