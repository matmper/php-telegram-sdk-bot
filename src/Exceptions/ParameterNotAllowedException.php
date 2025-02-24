<?php

declare(strict_types=1);

namespace Matmper\Exceptions;

use Exception;
use Throwable;

class ParameterNotAllowedException extends Exception
{
    /**
     * @param string $parameter
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $parameter, int $code = 400, ?Throwable $previous = null)
    {
        $message = "Parameter is not allowed: {$parameter}";
        parent::__construct($message, $code, $previous);
    }
}
