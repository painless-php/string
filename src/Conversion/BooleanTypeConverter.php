<?php

namespace Nonetallt\String\Conversion;

use Nonetallt\String\Contract\TypeConverterInterface;
use Nonetallt\String\Exception\TypeConversionException;

class BooleanTypeConverter implements TypeConverterInterface
{
    public function convert(string $value) : bool
    {
        if($value === 'true' || $value === '1') {
            return true;
        } 

        if($value === 'false' || $value === '0') {
            return false;
        }

        throw TypeConversionException::fromConversion($this, $value);
    }
}
