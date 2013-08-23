<?php

require_once('../PHP/Base.php');
require_once('../../Vendor/autoload.php');

class PHPLiquidBase extends PHPBase
{

    public $language = 'Liquid';
    public $fileFormat = '.liquid';

    public function getResults($template, $output, $directory) {
        $liquid = new LiquidTemplate();

        return $liquid->parse($template)->render($output);


    }

}