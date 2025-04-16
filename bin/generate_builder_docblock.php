<?php

use PainlessPHP\String\Str;
use PainlessPHP\String\StrBuilder;

require_once __DIR__ . '/../vendor/autoload.php';

$strClass = Str::class;
$builderClass = StrBuilder::class;
$reflection = new ReflectionClass($strClass);
$docblock = "/**\n *\n *\n";

foreach ($reflection->getMethods() as $method) {
    if(! $method->isStatic() || $method->isProtected() || $method->isPrivate()) {
        continue;
    }
    $docblock .= " * @method static \\$strClass|$builderClass {$method->getName()}()\n";
}
$docblock .= ' */';
echo $docblock . PHP_EOL;

$builderClassFile = __DIR__ . '/../src/StrBuilder.php';
$classDeclarationLine = (new ReflectionClass($builderClass))->getStartLine();
$lines = file($builderClassFile);
