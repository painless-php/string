<?php

namespace Nonetallt\String\Conversion;

use Nonetallt\String\Contract\TypeConverterInterface;
use Nonetallt\String\Exception\TypeConversionException;

class NullTypeConverter implements TypeConverterInterface
{
    public function convert(string $value)
    {
        if($value === 'null' || $value === '') {
            return null;
        }

        throw TypeConversionException::fromConversion($value, $this);
    }
}
