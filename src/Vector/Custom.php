<?php

namespace Phperf\Pipeline\Vector;


class Custom implements VectorProcessor
{
    /** @var callable */
    private $callable;

    public function __construct(callable $callable)
    {
        $this->callable = $callable;
    }

    public function value($value)
    {
        $c = $this->callable;
        return $c($value);
    }


}