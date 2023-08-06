<?php

    namespace Templater\Exceptions;

    use Exception;
    use Throwable;

    class CachingException extends Exception {
        public function __construct($message = "Unable to cache file.", $code = 0, Throwable $previous = null) {
            parent::__construct($message, $code, $previous);
        }
    }