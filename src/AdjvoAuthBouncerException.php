<?php

namespace AdjvoAuthBouncer;

use Exception;
use Throwable;

class AdjvoAuthBouncerException extends Exception
{
    /**
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @return void
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
