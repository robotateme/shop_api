<?php

namespace App\Service\Exceptions;

use Exception;

class CalculatePriceException extends Exception
{
    protected $message = "";
    protected $code = 400;
}
