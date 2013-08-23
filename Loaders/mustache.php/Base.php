<?php

require_once('../../Vendor/autoload.php');

class MustacheBase extends PHPUnit_Framework_TestCase
{

    public $language = 'Mustache';
    public $fileFormat = '.mustache';

    /**
     * @dataProvider provider
     */
    public function testAdd($file, $message, $template, $output)
    {
        $m = new Mustache_Engine(array(
            'partials_loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__).'/../../test/Mustache/'.dirname($file)),
        ));
        

        try {
            $result = $m->loadTemplate($template)->render($output[0]);
        } catch (Exception $e) {
            $result = trim(sprintf('%s: %s', get_class($e), $e->getMessage()));
        }
        $expected = $output[1];

        $this->assertEquals($expected, $result, $file);

    }

    public function provider()
    {
        $testDir = realpath(dirname(__FILE__).'/../../test/'.$this->language);
        $tests = array();

        foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($testDir), RecursiveIteratorIterator::LEAVES_ONLY) as $file) {
            if (!preg_match('/\.json$/', $file)) {
                continue;
            }

            $test = json_decode(file_get_contents($file->getRealpath()), true);

            $message = "Test";
            $template = file_get_contents($file->getPath().'/template'.$this->fileFormat);
            foreach($test as $key=>$value) {
                $output = array($value, file_get_contents($file->getPath().'/'.($key+1).'.html'));
                $tests[str_replace($testDir.'/', '', $file->getPath().'/'.($key+1).'.html')] = array(str_replace($testDir.'/', '', $file->getPath().'/'.($key+1).'.html'), $message, $template, $output);
            }

            
        }

        return $tests;
    }
}