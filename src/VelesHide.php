<?php

namespace MaximAntonisin\Veles;

use MaximAntonisin\Veles\Type\EmailTypeInterface;
use MaximAntonisin\Veles\Type\StringTypeInterface;
use MaximAntonisin\Veles\Type\UrlTypeInterface;

/**
 * Veles Hide String.
 * This class is designed to work with different types of string formats (plain string, email, phone number etc.) and to
 * replace chars with special symbol (by default `*`) for security hide from personal information (usually). Class is
 * implemented as abstract class with static methods.
 *
 * @author Maxim Antonisin <maxim.antonisin@gmail.com>
 *
 * @version 1.3.0
 */
abstract class VelesHide
{
    /**
     * Allowed types.
     * This constant describe which string type format is allowed as argument or data processing.
     */
    const ALLOWED_TYPES = [
        'string' => StringTypeInterface::class,
        'email'  => EmailTypeInterface::class,
        'url'    => UrlTypeInterface::class,
    ];


    /**
     * Base hide method to hide sensitive data.
     * This method is designed to receive as argument a string (in different format) and to hide personal sensitive
     * data with special symbol. Data processing depend on second method argument $type. By default, type is
     * StringType::class. As last 3rd, this method may receive an array of additional options. All possible and valid
     * options are described in type class or base type class (ex emailEmailType::class, StringType::class,
     * BaseType::class) and depends on string type format. All class type properties may be received in options array.
     * Method will return a processed string.
     *
     * @param string $value   - Value to be processed to hide sensitive data with special char.
     * @param array  $options - Additional options used on processing. All options depend on string type format and
     *                          type class.
     * @param string $type    - String format type (Allowed types stored in VelesHide::ALLOWED_TYPES constant array).
     *
     * @return string
     *
     * @throws \Exception
     */
    public static function hide(string $value, array $options = [], string $type = 'string'): string
    {
        /** Validate if type is valid and allowed. */
        if (!in_array($type, array_keys(self::ALLOWED_TYPES))) {
            throw new \Exception(
                sprintf(
                    'Invalid type. Type must be %s',
                    implode(', ', array_keys(self::ALLOWED_TYPES))
                )
            );
        }

        switch (self::ALLOWED_TYPES[$type]) {
            case EmailTypeInterface::class:
                return self::hideEmail($value, $options);
            case UrlTypeInterface::class:
                return self::hideUrl($value, $options);
            case StringTypeInterface::class:
            default:
                return self::hideString($value, $options);
        }
    }

    /**
     * Hide chars in string.
     * This method is designed to hide personal and sensitive information from simple string. Chars will be replaced
     * with special symbol. Method will return a processed string.
     *
     * @param string $value   - Value to be processed to hide sensitive data with special char.
     * @param array  $options - Additional options used on processing. All options depend on string type format and
     *                          type class.
     *
     * @return string
     */
    private static function hideString(string $value, array $options): string
    {
        $char   = $options[StringTypeInterface::OPTION_HIDE_CHAR] ?? StringTypeInterface::DEFAULT_HIDE_CHAR;
        $length = $options[StringTypeInterface::OPTION_LENGTH] ?? StringTypeInterface::DEFAULT_LENGTH;
        $offset = $options[StringTypeInterface::OPTION_OFFSET] ?? StringTypeInterface::DEFAULT_OFFSET;
        $hideLength = $options[StringTypeInterface::OPTION_HIDE_LENGTH] ?? false;

        return self::replaceString($value, $length, $char, $offset, $hideLength);
    }

    /**
     * Hide chars in email string.
     * This method is designed to hide personal and sensitive information from email string. Chars will be replaced with
     * special symbol. Method will return a processed string.
     *
     * @param string $value   - Email value string to be processed to hide sensitive data with special char.
     * @param array  $options - Additional options used on processing. All options depend on string type format and
     *                          type class.
     * @return string
     *
     * @throws \Exception
     */
    private static function hideEmail(string $value, array $options): string
    {
        /** Allowed only valid email values. */
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception('Invalid email.');
        }

        /** Process and Hide chars from email name part. */
        $parts = explode('@', $value);
        $parts[0] = self::hideString($parts[0], $options);

        /** Process and Hide chars from email domain part. In case when domainLength is 0, method will not update email
         * domain string part.*/
        $length = $options[EmailTypeInterface::OPTION_DOMAIN_LENGTH] ?? EmailTypeInterface::DEFAULT_DOMAIN_LENGTH;
        if (0 <= $length) {
            $offset = $options[EmailTypeInterface::OPTION_DOMAIN_OFFSET] ?? EmailTypeInterface::DEFAULT_DOMAIN_OFFSET;
            /** Get special char to replace sensitive or personal data. Value may be received from options or default
             * from class who describe used type of string format. */
            $char = $options[EmailTypeInterface::OPTION_HIDE_CHAR] ?? EmailTypeInterface::DEFAULT_HIDE_CHAR;

            $parts[1] = self::replaceString($parts[1], $length, $char, $offset);
        }

        return implode('@', $parts);
    }

    /**
     * Hide chars in url string.
     * This method is designed to hide personal and sensitive information from url string. Chars will be replaced with
     * special symbol. Method will return a processed string.
     *
     * @param string $value   - Url value string to be processed to hide sensitive data with special char.
     * @param array  $options - Additional options used on processing. All options depend on string type format and
     *                          type class.
     * @return string
     *
     * @throws \Exception
     */
    private static function hideUrl(string $value, array $options): string
    {
        /** Allowed only valid email values. */
        if (!filter_var($value, FILTER_VALIDATE_URL)) {
            throw new \Exception('Invalid Url value.');
        }

        $parts  = parse_url($value);
        $char   = $options[UrlTypeInterface::OPTION_HIDE_CHAR] ?? UrlTypeInterface::DEFAULT_HIDE_CHAR;
        $result = self::hideString($parts['host'], $options);
        if ($parts['port']) {
            $result = sprintf('%s:%s', $result, $parts['port']);
        }

        $patterns = [
            'scheme' => '%2$s://%1$s',
            'path'   => '%s%s',
            'query'  => '%s?%s',
        ];

        foreach ($patterns as $key => $pattern) {
            $length = $options[$key.'Length']
                ?? constant(sprintf('%s::DEFAULT_%s_LENGTH', UrlTypeInterface::class, strtoupper($key)))
            ;

            if ($length >= 0 and !empty($parts[$key])) {
                $offset = $options[$key.'Offset']
                    ?? constant(sprintf('%s::DEFAULT_%s_OFFSET', UrlTypeInterface::class, strtoupper($key)))
                ;
                $temp   = self::replaceString($parts[$key], $length, $char, $offset);
                $result = sprintf($pattern, $result, $temp);
            }
        }

        return $result;
    }

    /**
     * Replace chars in string.
     * This method is designed to replace chars in string with special char. Number of chars to be changed, depends on
     * second argument $length and $value string length. First replaced char may be offset with last argument $offset.
     * Method will return a processed string.
     *
     * @param string $value      - String value to be processed and replaced chars.
     * @param int    $length     - Number of chars to be replaced by special $char.
     * @param string $char       - Special symbol used to replace chars from string.
     * @param int    $offset     - Offset first char to be replaced.
     * @param bool   $hideLength - Hide length of chars to be replaced.
     *
     * @return string
     */
    private static function replaceString(
        string $value,
        int $length = 0,
        string $char = '*',
        int $offset = 0,
        bool $hideLength = false
    ): string
    {
        if (0 === $length) {
            return $value;
        }

        if ($length + $offset > strlen($value)) {
            $length = strlen($value) - $offset;
        }

        if ($offset > strlen($value)) {
            return $value;
        }
        if (false === $hideLength) {
            $char = str_repeat($char, $length);
        }
        $pattern = sprintf('/^(.{%s}).{1,%s}/', $offset, $length ?: 1);
        $replace = sprintf('$1%s', $char);

        return preg_replace($pattern, $replace, $value) ?? $value;
    }
}
