<?php

namespace MaximAntonisin\Veles;

use Twig\TwigFunction;

/**
 * Class Twig Hide Function.
 * This class is implemented as twig function to hide user personal/sensitive data.
 *
 * @author Maxim Antonisin <maxim.antonisin@gmail.com>
 *
 * @version 1.1.0
 */
class VelesHideFunction
{
    /**
     * Return array of functions.
     * This method will return array of functions described in this class.
     */
    public static function getFunctions(): array
    {
        return [
            new TwigFunction('hide', [VelesHideFunction::class,'hide']),
            new TwigFunction('stringHide', [VelesHideFunction::class, 'hide']),
            new TwigFunction('velesHide', [VelesHideFunction::class, 'hide']),
        ];
    }

    /**
     * Return function instance.
     * This method is designed to return twig function instance.
     * By default method is not implemented and will trigger an exception.
     *
     * @throws \Exception
     */
    public static function getFunction(): TwigFunction
    {
        throw new \Exception("Method not used");
    }

    /**
     * Call VelesHide method hide.
     * This method is used as middleware to catch errors and exceptions on using hide method from VelesHide class.
     *
     * @param string $value   - Value to be processed to hide sensitive data with special char.
     * @param array  $options - Additional options used on processing. All options depends on string type format and
     *                          type class.
     * @param string $type    - String format type (Allowed types stored in VelesHide::ALLOWED_TYPES constant array).
     *
     * @return string
     */
    public static function hide(string $value, array $options = [], string $type = 'string'): string
    {
        try {
            return VelesHide::hide($value, $options, $type);
        } catch (\Exception $exception) {
            error_log(sprintf('Error on hide personal data in string. %s', $exception->getMessage()));

            return $value;
        }
    }
}
