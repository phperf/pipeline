<?php

namespace Phperf\Pipeline\Vector;

class DropAnomaly implements VectorProcessor
{
    private $deviation;
    private $prevValue;
    /** @var VectorProcessor */
    private $processor;

    public function __construct($deviation = 0.5)
    {
        $this->deviation = $deviation;
        $this->processor = new MovingAverage(6);
    }

    public function value($value)
    {
        if (null !== $this->prevValue) {
            $delta = abs($value - $this->prevValue);
            $allowedDelta = abs($this->deviation * $this->prevValue);
            if ($delta > $allowedDelta) {
                return null;
            } else {
                $this->prevValue = $this->processor->value($value);
                return $value;
            }
        } else {
            $this->prevValue = $this->processor->value($value);
            return $value;
        }
    }
}