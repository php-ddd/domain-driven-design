<?php

namespace PhpDDD\DomainDrivenDesign\Exception;

/**
 *
 */
final class InvalidArgumentException extends \InvalidArgumentException implements ExceptionInterface
{
    public static function wrongType($argumentName, $value, $expectedType)
    {
        return new self(
            sprintf(
                'The parameter "%s" expect to be of type %s, %s given.',
                $argumentName,
                $expectedType,
                is_object($value) ? get_class($value) : gettype($value)
            )
        );
    }
}
