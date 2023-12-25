<?php
declare(strict_types=1);

namespace Doxadoxa\PhpIndicators;

use Exception;

class TOHLCV
{
    private $timestamp;
    private $open;
    private $high;
    private $low;
    private $close;
    private $volume;

    private $indicators;

    public function __construct( array $candles )
    {
        $this->timestamp = new ArrayIndicator( array_column( $candles, 0 ) );
        $this->open = new ArrayIndicator( array_column( $candles, 1 ) );
        $this->high = new ArrayIndicator( array_column( $candles, 2 ) );
        $this->low = new ArrayIndicator( array_column( $candles, 3 ) );
        $this->close = new ArrayIndicator( array_column( $candles, 4 ) );
        $this->volume = new ArrayIndicator( array_column( $candles, 5 ) );

        $this->indicators = new Indicators();
    }

    /**
     * @return ArrayIndicator
     */
    public function timestamp(): ArrayIndicator
    {
        return $this->timestamp;
    }

    /**
     * @return ArrayIndicator
     */
    public function open(): ArrayIndicator
    {
        return $this->open;
    }

    /**
     * @return ArrayIndicator
     */
    public function high(): ArrayIndicator
    {
        return $this->high;
    }

    /**
     * @return ArrayIndicator
     */
    public function low(): ArrayIndicator
    {
        return $this->low;
    }

    /**
     * @return ArrayIndicator
     */
    public function close(): ArrayIndicator
    {
        return $this->close;
    }

    /**
     * @return ArrayIndicator
     */
    public function volume(): ArrayIndicator
    {
        return $this->volume;
    }

    /**
     * @param int $period
     * @return ArrayIndicator
     * @throws Exception
     */
    public function atr( int $period ): ArrayIndicator
    {
        return $this->indicators->atr( $this->high, $this->low, $this->close, $period);
    }

    /**
     * @return float
     */
    public function hl2(): float
    {
        return ( $this->high[0] + $this->low[0] ) / 2;
    }

    /**
     * @return float
     */
    public function co2(): float
    {
        return ( $this->close[0] + $this->open[0] ) / 2;
    }

    /**
     * @param callable $callback
     * @return ArrayIndicator
     */
    public function mapOC( callable $callback ): ArrayIndicator
    {
        return new ArrayIndicator(
            array_map( $callback,
                $this->open->toArray(),
                $this->close->toArray()
            )
        );
    }

    /**
     * @param callable $callback
     * @return ArrayIndicator
     */
    public function mapHL( callable $callback ): ArrayIndicator
    {
        return new ArrayIndicator(
            array_map( $callback,
                $this->high->toArray(),
                $this->low->toArray()
            )
        );
    }

    /**
     * @param callable $callback
     * @return ArrayIndicator
     */
    public function mapOHLC( callable $callback ): ArrayIndicator
    {
        return new ArrayIndicator(
            array_map( $callback,
                $this->open->toArray(),
                $this->high->toArray(),
                $this->low->toArray(),
                $this->close->toArray()
            )
        );
    }

    /**
     * @param callable $callback
     * @return ArrayIndicator
     */
    public function mapOHLCV( callable $callback ): ArrayIndicator
    {
        return new ArrayIndicator(
            array_map( $callback,
                $this->open->toArray(),
                $this->high->toArray(),
                $this->low->toArray(),
                $this->close->toArray(),
                $this->volume->toArray(),
            )
        );
    }
}
