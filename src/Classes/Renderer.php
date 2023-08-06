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