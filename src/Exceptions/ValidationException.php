<?php

namespace DataLinx\DPD\Exceptions;

use Exception;
use Throwable;

/**
 * Request validation exception
 */
class ValidationException extends Exception
{
    public const CODE_ATTR_REQUIRED = 1;

    public string $attribute;

    /**
     * @param string $attribute Request attribute
     * @param int $code Exception code (see class constants)
     * @param Throwable|null $previous
     */
    public function __construct(string $attribute, int $code, Throwable $previous = null)
    {
        parent::__construct($this->prepMessage($attribute, $code), $code, $previous);

        $this->attribute = $attribute;
    }

    /**
     * Create the message based on the exception code
     *
     * @param string $attribute
     * @param string $code
     * @return string
     * @noinspection DegradedSwitchInspection
     */
    private function prepMessage(string $attribute, string $code): string
    {
        switch ($code) {
            case self::CODE_ATTR_REQUIRED:
            default:
                return "Attribute \"$attribute\" is required";
        }
    }
}
