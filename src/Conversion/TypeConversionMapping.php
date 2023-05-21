<?php

namespace PainlessPHP\String\Conversion;

/**
 * Simple alias to converter mapping, not ment as part of the public API
 *
 */
class TypeConversionMapping
{
    CONST MAPPING = [
        'boolean' => BooleanTypeConverter::class,
        'integer' => IntegerTypeConverter::class,
        'float'   => FloatTypeConverter::class
    ];
}
