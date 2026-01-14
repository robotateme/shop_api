<?php

namespace App\Service\Exceptions;

use Exception;

class PurchaseException extends Exception
{
    protected $message = "";
    protected $code = 400;
}
