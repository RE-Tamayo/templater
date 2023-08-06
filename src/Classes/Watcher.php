<?php

    namespace Templater\Classes;

    class Watcher {

        private string $templatesDir;

        public function __construct(string $templatesDir) {
            $this->templatesDir = $templatesDir;
        }

        public function hasFileChanged(string $identifier, string $cachePath): bool {
            $identifier = str_replace(".", DIRECTORY_SEPARATOR, $identifier);
            $templateModificationTime = filemtime($this->templatesDir.DIRECTORY_SEPARATOR.$identifier.".php");
            $cacheModificationTime = filemtime($cachePath);

            if($templateModificationTime > $cacheModificationTime) {
                return true;
            }   
            return false;
        }
    }