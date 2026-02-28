<?php

namespace App\Exceptions\Custom;

use Exception;

class UnauthorizedTenantAccessException extends Exception
{
    protected $message = 'Unauthorized access to tenant';
    protected $code = 403;
}
