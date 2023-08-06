<?php

    namespace Templater;

    use Templater\Classes\Facade;

    class Templater {

        private Facade $templater;

        public function __construct() {
            $this->templater = new Facade();
        }

        public function view(string $template, string $layout = ""): void {
            $this->templater->getView($template, $layout);
        }
    }