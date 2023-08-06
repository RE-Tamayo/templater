<?php
    include "../vendor/autoload.php";

    use Templater\Templater;

    $templater = new Templater();

    $templater->view("pages.index", "layouts.app");

