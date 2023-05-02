<?php

declare(strict_types=1);

namespace App\Exceptions;

class NoSuchUserException extends \Exception
{
    protected $message = "No such user!";
}
