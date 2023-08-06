<?php

    namespace Templater\Classes;

    class Compiler {

        private string $templatesDir;

        public function __construct(string $templatesDir) {
            $this->templatesDir = $templatesDir;
        }

        public function compile(string $identifier): string {
            $identifier = str_replace(".", DIRECTORY_SEPARATOR, $identifier);
            $file = file_get_contents($this->templatesDir.DIRECTORY_SEPARATOR.$identifier.".php");
            $compiledCode = $this->compileEchoes($file);
            return $compiledCode;
        }

        //compile echoes
        private function compileEchoes(string $code): string {
            $compiledCode = str_replace(['{{', '}}'], ['<?=', '?>'], $code);
            return $compiledCode;
        }

        //compile if, elseif, else, endif
        private function compileConditionals(string $code): string {
            return "";
        }

        //compile for, foreach
        private function compileLoops(string $code): string {
            return "";
        }

        //compile switch case
        //compile special directives: isset, empty, yield
    }