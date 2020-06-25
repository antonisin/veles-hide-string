<?php

namespace MaximAntonisin\Veles;

use Twig\TwigFilter;

/**
 * Class Twig Hide Filter.
 * This class is implemented as twig filter to hide user personal/sensitive data.
 *
 * @author Maxim Antonisin <maxim.antonisin@gmail.com>
 *
 * @version 1.0.0
 */
class VelesHideFilter
{
    /**
     * Return array of filers.
     * This method will return array of filters described in this class.
     */
    public static function getFilters(): array
    {
        return [
            new TwigFilter('hide', [VelesHideFunction::class,'hide']),
            new TwigFilter('stringHide', [VelesHideFunction::class, 'hide']),
            new TwigFilter('velesHide', [VelesHideFunction::class, 'hide']),
        ];
    }

    /**
     * Return filter instance.
     * This method is designed to return twig filter instance.
     * By default method is not implemented and will trigger an exception.
     *
     * @throws \Exception
     */
    public static function getFilter(): TwigFilter
    {
        throw new \Exception("Method not used");
    }
}
