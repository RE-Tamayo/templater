<?php
    include "../vendor/autoload.php";

    use Templater\Classes\Facade;

    $templater = new Facade();

    $templater->getView("a.afile");

    // echo $templater->locateCache('test.php');
