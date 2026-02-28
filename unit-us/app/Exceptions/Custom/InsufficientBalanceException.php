<?php

namespace App\Exceptions\Custom;

use Exception;

class InsufficientBalanceException extends Exception
{
    protected $message = 'Insufficient balance';
    protected $code = 400;
}
