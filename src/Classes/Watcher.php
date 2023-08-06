<?php

    namespace Templater\Classes;

    use Templater\Exceptions\TemplateNotFoundException;

    class Watcher {

        private string $templatesDir;

        public function __construct(string $templatesDir) {
            $this->templatesDir = $templatesDir;
        }

        public function hasFileChanged(string $identifier, string $cachePath): bool {
            set_error_handler(function ($errno, $errstr) {
                if (0 === error_reporting()) {
                    return false;
                }
                throw new TemplateNotFoundException();
                restore_error_handler();
                exit();
            });
            

            $identifier = str_replace(".", DIRECTORY_SEPARATOR, $identifier);
            $templateModificationTime = filemtime($this->templatesDir.DIRECTORY_SEPARATOR.$identifier.".php");
            $cacheModificationTime = filemtime($cachePath);

            if($templateModificationTime > $cacheModificationTime) {
                return true;
            }   
            return false;
        }

        public function hasLayoutChanged(string $identifier, string $cachePath): bool {
            set_error_handler(function ($errno, $errstr) {
                if (0 === error_reporting()) {
                    return false;
                }
                throw new TemplateNotFoundException();
                restore_error_handler();
                exit();
            });

            $identifier = str_replace(".", DIRECTORY_SEPARATOR, $identifier);
            $templateModificationTime = filemtime($this->templatesDir.DIRECTORY_SEPARATOR.$identifier.".layout.php");
            $cacheModificationTime = filemtime($cachePath);

            if($templateModificationTime > $cacheModificationTime) {
                return true;
            }   
            return false;
        }
    }