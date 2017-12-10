<?php

namespace Phperf\Pipeline\Vector;

class KalmanFilter implements VectorProcessor
{
    /** @var float|int Process noise (how variable data is expected to come) */
    public $processNoise;
    /** @var float|int Measurement noise (how strong is ) */
    public $measurementNoise;

    public $stateVector;
    public $controlVector;
    public $measurementVector;
    public $cov;
    public $x;


    /**
     * Create 1-dimensional kalman filter
     * @param float|int $processNoise Process noise
     * @param float|int $measurementNoise Measurement noise
     * @param float|int $stateVector State vector
     * @param float|int $controlVector Control vector
     * @param float|int $measurementVector Measurement vector
     * @param $cov
     * @param $x
     */
    function __construct($processNoise = 1, $measurementNoise = 1, $stateVector = 1, $controlVector = 0, $measurementVector = 1, $cov = null, $x = null)
    {
        $this->processNoise = $processNoise; // noise power desirable
        $this->measurementNoise = $measurementNoise; // noise power estimated

        $this->stateVector = $stateVector;
        $this->controlVector = $controlVector;
        $this->measurementVector = $measurementVector;

        $this->cov = $cov;
        $this->x = $x; // estimated signal without noise
    }

    /**
     * Filter a new value
     * @param  float $value Measurement
     * @param  float|int $u Control
     * @return float
     */
    function value($value, $u = 0)
    {
        if (null === $this->x) {
            $this->x = (1 / $this->measurementVector) * $value;
            $this->cov = (1 / $this->measurementVector) * $this->measurementNoise * (1 / $this->measurementVector);
        } else {
            // Compute prediction
            $predX = ($this->stateVector * $this->x) + ($this->controlVector * $u);
            $predCov = (($this->stateVector * $this->cov) * $this->stateVector) + $this->processNoise;

            // Kalman gain
            $K = $predCov * $this->measurementVector *
                (1 / (($this->measurementVector * $predCov * $this->measurementVector) + $this->measurementNoise));

            // Correction
            $this->x = $predX + $K * ($value - ($this->measurementVector * $predX));
            $this->cov = $predCov - ($K * $this->measurementVector * $predCov);
        }

        return $this->x;
    }
}
