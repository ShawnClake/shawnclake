<?php namespace Clake\UnitTests\Components;

use Cms\Classes\ComponentBase;
use Config;

class Controller extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Controller',
            'description' => 'Place on a page to test all your test drivers and receive feedback'
        ];
    }

    public function results()
    {
        $tests = Config::get('clake.unittests::drivers', null);

        if(is_null($tests))
            return "Err: No test drivers. Check configuration file.";

        $results = '';

        foreach($tests as $test)
        {
            $class = new $test;
            $results[$test] = $class::test();
        }

        return $results;

    }

    public function defineProperties()
    {
        return [];
    }

}