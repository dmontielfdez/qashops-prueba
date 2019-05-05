<?php

namespace app\infrastructure\exceptions;

class CsvReaderException extends \Exception
{
    public static function withMessage($message)
    {
        return new self("Error reading CSV with message: '{$message}'");
    }
}