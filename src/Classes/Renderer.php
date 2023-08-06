<?php

    namespace Templater\Classes;

    class Renderer {

        public string $templatesDir;

        public function __construct($templatePath = "") {
            $this->templatesDir = $this->createTemplateDir($templatePath);
        }

        public function render(string $path): void {
            include $path;
        }

        public function templateExist(string $identifier): bool {
            $identifier = str_replace(".", DIRECTORY_SEPARATOR, $identifier);
            return file_exists($this->templatesDir.DIRECTORY_SEPARATOR.$identifier.".php");
        }

        public function layoutExist(string $layout): bool {
            $layout = str_replace(".", DIRECTORY_SEPARATOR, $layout);
            return file_exists($this->templatesDir.DIRECTORY_SEPARATOR.$layout.".php");
        }

        private function createTemplateDir(string $templatePath): string {
            if($templatePath === "") {
                $dir = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'templates';
            }
            else {
                $dir = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.$templatePath.DIRECTORY_SEPARATOR.'templates';
            }
            if(!is_dir($dir))
            {
                mkdir($dir, 0777, true);
            }

            return $dir;
        }
    }