<?php

namespace App\Support;

use Stringable;

class Number implements Stringable
{
    /**
     * @param  int|float|string $number
     */
    public function __construct(protected int|float|string $number)
    {
        //
    }

    /**
     * @param  int         $decimals
     * @param  string|null $thousands_separator
     * @param  string|null $decimal_separator
     * @param  bool        $precision
     * @return Number
     */
    public function format(int $decimals = 0, ?string $thousands_separator = '.', ?string $decimal_separator = ',', bool $precision = false) : Number
    {
        if ($precision) {
            // separate decimal and integer parts
            $parts = explode('.', (string) $this->number);

            // integer part
            $integer = $parts[0];

            // format number with thousand separator
            $formatted = number_format($integer, $decimals, $decimal_separator, $thousands_separator);

            // if decimal part exists
            if (isset($parts[1])) {
                // limit decimal part to maximum 2 digits
                $decimal = substr($parts[1], 0, 2);
                // add trailing zero if only 1 digit
                if (strlen($decimal) === 1) {
                    $decimal .= '0';
                }

                $formatted .= ',' . $decimal;
            }
        } else {
            $formatted = number_format($this->number, 0, '', $thousands_separator);
        }

        $this->number = $formatted;

        return $this;
    }

    /**
     * @param  int  $decimals
     * @param  bool $short
     * @return $this
     */
    public function abbr(int $decimals = 2, bool $short = true) : static
    {
        $number = $this->number;

        $abbreviations = $short ? ['', 'RB', 'JT', 'M', 'T'] : ['', ' Ribu', ' Juta', ' Miliar', ' Triliun'];

        $absolute = abs($this->number);
        $index = 0;

        while ($absolute >= 1000 && $index < count($abbreviations) - 1) {
            $absolute /= 1000;
            $index++;
        }

        $formatted = number_format($absolute, $decimals, ',', '.');

        // Remove trailing zeros after decimal point
        if ($decimals > 0) {
            $formatted = rtrim(rtrim($formatted, '0'), ',');
        }

        $sign = $number < 0 ? '-' : '';

        $this->number = "{$sign} {$formatted} {$abbreviations[$index]}";

        return $this;
    }

    /**
     *  converts a number to indonesian rupiah currency format
     *
     * @param  string $prefix
     * @param  bool   $abbr
     * @param  bool   $precision
     * @return $this
     */
    public function currency(string $prefix = 'Rp ', bool $abbr = false, bool $precision = false) : static
    {
        if ($abbr) {
            $this->abbr();
        }

        if (! $abbr) {
            $this->format(precision: $precision);
        }

        $this->number = $prefix . $this->number;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->number;
    }
}
