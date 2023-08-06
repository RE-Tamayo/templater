<?php

    namespace Templater\Exceptions;

    use Exception;
    use Throwable;

    class TemplateNotFoundException extends Exception {
        public function __construct($message = "Unable to find referenced template.", $code = 0, Throwable $previous = null) {
            parent::__construct($message, $code, $previous);
        }
    }