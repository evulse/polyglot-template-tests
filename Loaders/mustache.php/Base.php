<?php

require_once('../PHP/Base.php');
require_once('../../Vendor/autoload.php');

class MustacheBase extends PHPBase
{

    public $language = 'Mustache';
    public $fileFormat = '.mustache';

    public function getResults($template, $output, $directory) {
        $m = new Mustache_Engine(array(
            'partials_loader' => new Mustache_Loader_FilesystemLoader($directory),
        ));
        
        return $m->loadTemplate($template)->render($output);
    }

}