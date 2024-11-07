<?php

namespace App\Mapper;

use Exception;

class ProductMappingException extends Exception
{
    public function __construct(string $message = "Invalid product data provided.", int $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
