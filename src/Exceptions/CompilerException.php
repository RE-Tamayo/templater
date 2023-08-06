<?php

    namespace Templater\Exceptions;

    use Exception;
    use Throwable;

    class CompilerException extends Exception {
        public function __construct($message = "Unable to compile template! Please check that the template referenced exists.", $code = 0, Throwable $previous = null) {
            parent::__construct($message, $code, $previous);
        }
    }