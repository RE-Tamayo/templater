<?php
    include "../vendor/autoload.php";

    use Templater\Classes\Facade;

    $templater = new Facade();

    $templater->getView("text", "test");

    // echo $templater->locateCache('test.php');
