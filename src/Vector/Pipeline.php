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

    public function value($value)
    {
        if ($value === null) {
            return null;
        }
        foreach ($this->processors as $processor) {
            $value = $processor->value($value);
            if ($value === null) {
                break;
            }
        }
        return $value;
    }
}