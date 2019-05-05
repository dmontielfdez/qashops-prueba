<?php

namespace app\infrastructure\exceptions;

class CsvWriterException extends \Exception
{
    public static function withMessage($message)
    {
        return new self("Error writing CSV with message: '{$message}'");
    }
}