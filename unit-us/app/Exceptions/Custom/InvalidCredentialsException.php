<?php

namespace App\Exceptions\Custom;

use Exception;

class InvalidCredentialsException extends Exception
{
    protected $message = 'Invalid credentials';
    protected $code = 401;
}
