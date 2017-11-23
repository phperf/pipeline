<?php

namespace Phperf\Pipeline\Vector;

class DropAnomaly implements VectorProcessor
{
    private $deviation;
    private $prevValue;

    public function __construct($deviation = 0.5)
    {
        $this->deviation = $deviation;
    }

    public function value($value)
    {
        if (null !== $this->prevValue) {
            $delta = abs($value - $this->prevValue);
            $allowedDelta = abs($this->deviation * $this->prevValue);
            if ($delta > $allowedDelta) {
                return null;
            } else {
                return $value;
            }
        } else {
            $this->prevValue = $value;
            return $value;
        }
    }
}