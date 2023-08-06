<?php

    namespace Templater\Exceptions;

    use Exception;
    use Throwable;

    class CacheLocationException extends Exception {
        public function __construct($message = "Unable to locate cached file", $code = 0, Throwable $previous = null) {
            parent::__construct($message, $code, $previous);
        }
    }