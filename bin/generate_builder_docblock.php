<?php

use PainlessPHP\String\Str;

require_once __DIR__ . '/../vendor/autoload.php';

$reflection = new ReflectionClass(Str::class);
$docblock = "/**\n *\n *\n";

foreach ($reflection->getMethods() as $method) {
    if(! $method->isStatic() || $method->isProtected() || $method->isPrivate()) {
        continue;
    }

    $args = [];
    foreach($method->getParameters() as $param) {
        $args[] = Str::join(' ', $param->getType(), ($param->isVariadic() ? '...' : '') . "\${$param->getName()}");
    }
    $args = implode(', ', $args);
    $docblock .= ' * @method static ' . Str::join(' ', $method->getReturnType(), $method->getName(), "($args)\n");
}
$docblock .= ' */';
echo $docblock . PHP_EOL;

$builderClassFile = __DIR__ . '/../src/StrBuilder.php';
$lines = file($builderClassFile);

$handle = fopen($builderClassFile, 'w');
foreach($lines as $index => $line) {
    // Skip existing docblock lines
    if(str_starts_with($line, '/**') || str_starts_with($line, ' *')) {
        continue;
    }
    // Write the new docblock before class
    if(str_starts_with($line, 'class StrBuilder')) {
        fwrite($handle, "$docblock\n");
    }
    fwrite($handle, $line);
}
fclose($handle);
