<?php

namespace App\Exceptions\Custom;

use Exception;

class EmployeeNotFoundException extends Exception
{
    protected $message = 'Employee not found';
    protected $code = 404;
}
