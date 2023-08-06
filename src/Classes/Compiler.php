<?php

    namespace Templater\Classes;

    use Templater\Exceptions\CompilerException;

    class Compiler {

        private string $templatesDir;
        private string $layoutsDir;

        public function __construct(string $templatesDir, string $layoutDir = "") {
            $this->templatesDir = $templatesDir;
            $this->layoutsDir = $layoutDir;
        }

        public function compile(string $identifier): string {
            try {
                $identifier = str_replace(".", DIRECTORY_SEPARATOR, $identifier);
                $file = file_get_contents($this->templatesDir.DIRECTORY_SEPARATOR.$identifier.".php");
            } catch (CompilerException $th) {
                throw new CompilerException();
            }
            $compiledCode = $this->compileEchoes($file);
            return $compiledCode;
        }

        public function compileWithLayout(string $identifier, string $layout): string {
            try {
                $identifier = str_replace(".", DIRECTORY_SEPARATOR, $identifier);
                $file = file_get_contents($this->templatesDir.DIRECTORY_SEPARATOR.$identifier.".php");

                $layout = str_replace(".", DIRECTORY_SEPARATOR, $layout);
                $layoutFile = file_get_contents($this->templatesDir.DIRECTORY_SEPARATOR.$layout.".layout.php");
            } catch (CompilerException $th) {
                throw new CompilerException();
            }
            
            $content = $this->compileEchoes($file);

            $layoutContent = $this->compileYield($content, $layoutFile);

            $layoutContent = $this->compileEchoes($layoutContent);

            return $layoutContent;
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

        private function compileYield(string $templateCode, string $layoutCode): string {
            $compiledCode = preg_replace('/\[\s*YIELD\s*\]/', $templateCode, $layoutCode);
            return $compiledCode;
        }

        //compile switch case
        //compile special directives: isset, empty, yield
    }