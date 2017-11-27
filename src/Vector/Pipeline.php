<?php

namespace Phperf\Pipeline\Vector;

class Pipeline implements VectorProcessor
{
    /** @var VectorProcessor[] */
    private $processors = [];

    public function addProcessor(VectorProcessor $processor)
    {
        $this->processors[] = $processor;
        return $this;
    }

    private $lastValue;

    public function getLastValue()
    {
        return $this->lastValue;
    }

    public function value($value)
    {
        if ($value === null) {
            $this->lastValue = null;
            return null;
        }
        foreach ($this->processors as $processor) {
            $value = $processor->value($value);
            if ($value === null) {
                break;
            }
        }
        $this->lastValue = $value;
        return $value;
    }
}