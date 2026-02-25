<?php

namespace App\Exceptions\Custom;

use Exception;

class TenantCreationException extends Exception
{
    protected $message = 'Failed to create tenant database';
    protected $code = 500;
}
