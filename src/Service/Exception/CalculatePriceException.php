<?php

namespace App\Service\Exception;

use Exception;

class CalculatePriceException extends Exception
{
    protected $message = "";
    protected $code = 400;
}
