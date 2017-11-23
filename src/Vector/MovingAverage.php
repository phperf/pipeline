<?php

namespace Phperf\Pipeline\Vector;


class MovingAverage implements VectorProcessor
{
    private $size;

    private $values = [];

    public function __construct($size)
    {
        $this->size = $size;
    }

    /**
     * @param $value
     * @return int
     * @todo optimize for fixed size array
     */
    public function value($value)
    {
        $result = $value;
        $cnt = 1;
        foreach ($this->values as $prev) {
            $result += $prev;
            ++$cnt;
        }
        if ($cnt > 1) {
            $result /= $cnt;
        }
        if (count($this->values) >= $this->size) {
            array_shift($this->values);
        }
        $this->values[] = $value;
        return $result;
    }
}