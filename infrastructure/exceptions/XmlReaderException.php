<?php

namespace app\infrastructure\exceptions;

class XmlReaderException extends \Exception
{
    public static function withMessage($message)
    {
        return new self("Error reading Xml with message: '{$message}'");
    }
}