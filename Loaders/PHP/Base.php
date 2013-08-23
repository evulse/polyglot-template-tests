<?php

require_once('../../Vendor/php-liquid/Liquid.class.php');

class PHPBase extends PHPUnit_Framework_TestCase
{

    public $language = 'PHP';
    public $fileFormat = '.php';

    /**
     * @dataProvider provider
     */
    public function testAdd($file, $message, $template, $output)
    {
        $directory = dirname(__FILE__).'/../../test/'.$this->language.'/'.dirname($file);
        try {
            $result = $this->getResults($template, $output[0], $directory);
        } catch (Exception $e) {
            $result = trim(sprintf('%s: %s', get_class($e), $e->getMessage()));
        }
        $expected = $output[1];

        $this->assertEquals($expected, $result, $file);

    }
    
    public function getResults($template, $output) {
        return false;
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