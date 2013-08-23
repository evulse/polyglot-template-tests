<?php

require_once('../PHP/Base.php');
require_once('../../Vendor/autoload.php');

class TwigBase extends PHPBase
{

    public $language = 'Twig';
    public $fileFormat = '.twig';

    public function getResults($template, $output, $directory) {
        $loader = new Twig_Loader_String();
        $twig = new Twig_Environment($loader);

        return $twig->render($template, $output);
    }

}