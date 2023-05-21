<?php

namespace PainlessPHP\String\Conversion;

/**
 * Simple alias to converter mapping, not ment as part of the public API
 *
 */
class StringTypeConversionMapping
{
    public CONST MAPPING = [
        'boolean' => StringToBooleanTypeConverter::class,
        'integer' => StringToIntegerTypeConverter::class,
        'float'   => StringToFloatTypeConverter::class,
        'null'    => StringToNullTypeConverter::class,
    ];
}
