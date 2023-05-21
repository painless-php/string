# PainlessPHP\String\Exception\TypeConversionException



## Methods

```php
public function __construct(string $message, int $code = 0, Exception $previous = null);

public function __toString();

public function __wakeup();

public static function fromConversion($value, PainlessPHP\String\Contract\TypeConverterInterface $converter = null, int $code = 0, Exception $previous = null) : self;

final public function getCode();

final public function getFile();

final public function getLine();

final public function getMessage();

final public function getPrevious();

final public function getTrace();

final public function getTraceAsString();
```
