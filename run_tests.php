<?php

class Normalise {

    static function loadJsonSingle($file, $test) {
        return json_decode(file_get_contents(dirname(__FILE__).'/results/'.$test->name.'/current/'.$file));
    }

    static function loadJsonMultiple($file, $test)
    {
        $json = file_get_contents(dirname(__FILE__).'/results/'.$test->name.'/current/'.$file);
        $q = FALSE;
        $objects = array();
        $return = array();
        $len = strlen($json);
        for($l=$c=$i=0;$i<$len;$i++)
        {
            $json[$i] == '"' && ($i>0?$json[$i-1]:'') != '\\' && $q = !$q;
            if(!$q && in_array($json[$i], array(" ", "\r", "\n", "\t"))){continue;}
            in_array($json[$i], array('{', '[')) && !$q && $l++;
            in_array($json[$i], array('}', ']')) && !$q && $l--;
            (isset($objects[$c]) && $objects[$c] .= $json[$i]) || $objects[$c] = $json[$i];
            $c += ($l == 0);
        }
        foreach($objects as $row) {
            $return[] = json_decode($row);
        }
        return $return;
    }

    static function findBetween($string,$start,$end){
        preg_match_all('/' . preg_quote($start, '/') . '(.*?)'. preg_quote($end, '/').'/i', $string, $m);
        $out = array();

        foreach($m[1] as $key => $value){
            $type = explode('::',$value);
            if(sizeof($type)>1){
                if(!is_array($out[$type[0]]))
                    $out[$type[0]] = array();
                $out[$type[0]][] = $type[1];
            } else {
                $out[] = $value;
            }
        }
        return $out;
    }

    static function removePrefix($prefix, $str) {
        if (substr($str, 0, strlen($prefix)) == $prefix) {
            $str = substr($str, strlen($prefix));
        }

        return $str;
    }

    static function processJS($file, $test) {
        $result = array();
        $array = Normalise::loadJsonSingle($file->directory.'.'.$file->resultType, $test);
        foreach($array->failures as $row) {
            $result[Normalise::removePrefix('../../test/'.$test->name.'/', $row->title)] = "fail";
        }
        foreach($array->passes as $row) {
            if($row->title != 'Always Pass') {
                $result[Normalise::removePrefix('../../test/'.$test->name.'/', $row->title)] = "pass";
            }
        }
        return $result;
    }

    static function processRuby($file, $test) {
        $result = array();
        $array = Normalise::loadJsonMultiple($file->directory.'.'.$file->resultType, $test);
        foreach($array as $row) {
            if($row->type == "test") {
                $result[Normalise::removePrefix('test_./../../test/'.$test->name.'/', $row->label)] = $row->status;
            }
        }
        return $result;
    }

    static function processPHP($file, $test) {
        $result = array();
        $array = Normalise::loadJsonMultiple($file->directory.'.'.$file->resultType, $test);
        foreach($array as $row) {
            if($row->event == "test") {
                $result[Normalise::findBetween($row->test, '"','"')[0]] = $row->status;
            }
        }
        return $result;
    }
    
}

class Test {
    
    public $name;
    public $libraries;
    public $result;
    public $default;
    
    function __construct($name) {
        $this->name = $name;
    }
    
    function registerLibrary($name, $default = false){

        $libDir = dirname(__FILE__).DIRECTORY_SEPARATOR.'Loaders'.DIRECTORY_SEPARATOR.$name;
        
        $this->libraries[$name] = json_decode(file_get_contents($libDir.DIRECTORY_SEPARATOR.'test.json'));
        if($default) {
           $this->default = $name; 
        }
        
    }
    
    function runTests() {
        foreach($this->libraries as $library) {
            $saveDir = dirname(__FILE__).DIRECTORY_SEPARATOR.'results'.DIRECTORY_SEPARATOR.$this->name.DIRECTORY_SEPARATOR.'current'.DIRECTORY_SEPARATOR.$library->directory.'.'.$library->resultType;
            chdir(dirname(__FILE__).DIRECTORY_SEPARATOR.'Loaders'.DIRECTORY_SEPARATOR.$library->directory);
            exec(sprintf($library->command, $saveDir));            
        }
    }
    
    function normaliseData() {
        foreach($this->libraries as $library) {
            $this->result[$library->directory] = call_user_func('Normalise::'.$library->normalise, $library, $this);
        } 
    }

    function prettyTestName($test) {
        return ucwords(str_replace('_', ' ', str_replace('/', ' - ', $test)));
    }

    function breakOut($arr) {
        $out = array();
        foreach ($arr as $key=>$val) {
            $r = & $out;
            foreach (explode("/", $key) as $key) {
                if (!isset($r[$key])) {
                    $r[$key] = array();
                }
                $r = & $r[$key];
            }
            $r = $val;
        }
        return $out;
    }
    
    function generateResults() {
        if($this->default) {
            $tests = array();
            
            foreach($this->result[$this->default] as $test=>$result) {
                $tests[$test]['pretty'] = $this->prettyTestName($test);
                $tests[$test]['test'] = $test;
                $tests[$test]['result'] = file_get_contents(dirname(__FILE__).'/test/'.$this->name.'/'.$test);
                $tests[$test]['template'] = file_get_contents(dirname(dirname(__FILE__).'/test/'.$this->name.'/'.$test).'/template.liquid');
                $tests[$test]['data'] = file_get_contents(dirname(dirname(__FILE__).'/test/'.$this->name.'/'.$test).'/data.json');
                foreach($this->result as $library=>$data) {
                    $tests[$test]['results'][$library] = $data[$test];
                }
            }

            file_put_contents(dirname(__FILE__).'/results/'.$this->name.'/current/results.json', json_encode($this->breakOut((array) $tests)));
        }

    }
}

$liquid = new Test('Liquid');
$liquid->registerLibrary('php-liquid');
$liquid->registerLibrary('liquid-node');
$liquid->registerLibrary('swig');
$liquid->registerLibrary('twig');
$liquid->registerLibrary('liquid', true);

$liquid->runTests();
$liquid->normaliseData();
$liquid->generateResults();