<?php

namespace Kirito\Component;

class Validator
{
    private $errorTip;

    public function __construct()
    {
        $this->errorTip = [
            'integer' => 'int...',
            'array' => 'array...',
            'string' => 'string....',
            'date' => 'data...',
        ];
    }

    public function validate($array, $rules)
    {
        return $array;
    }

}