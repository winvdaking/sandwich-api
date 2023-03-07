<?php

namespace orders\errors\renderer;

use Slim\Interfaces\ErrorRendererInterface;
use Throwable;

class ErrorRenderer implements ErrorRendererInterface
{
    public function __invoke(Throwable $exception, bool $displayErrorDetails): string
    {
        return json_encode([ 'type' => 'error', 'error' => $exception->getCode(), 'message' => $exception->getMessage()]);
    }
}