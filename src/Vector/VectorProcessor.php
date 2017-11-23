<?php

namespace Phperf\Pipeline\Vector;


interface VectorProcessor
{
    /**
     * @param $value
     * @return mixed|null
     */
    public function value($value);
}