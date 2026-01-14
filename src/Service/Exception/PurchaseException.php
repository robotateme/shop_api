<?php

namespace App\Service\Exception;

use Exception;

class PurchaseException extends Exception
{
    protected $message = "";
    protected $code = 400;
}
