<?php

namespace MaximAntonisin\Veles;

use MaximAntonisin\Veles\Type\StringType;
use MaximAntonisin\Veles\Type\EmailType;

/**
 * Veles Hide String.
 * This class is designed to work with different types of string formats (plain string, email, phone number etc.) and to
 * replace chars with special symbol (by default `*`) for security hide of personal information (usually). Class is
 * implemented as abstract class with static methods.
 *
 * @author Maxim Antonisin <maxim.antonisin@gmail.com>
 *
 * @version 1.0.0
 */
abstract class VelesHide
{
    /**
     * Allowed types.
     * This constant describe which string type format is allowed as argument or data processing.
     */
    const ALLOWED_TYPES = [
        'string' => StringType::class,
        'email'  => EmailType::class,
    ];


    /**
     * Base hide method to hide sensitive data.
     * This method is designed to receive as argument an string (in different format) and to hide personal sensitive
     * data with special symbol. Data processing depend on second method argument $type. By default type is
     * StringType::class. As last 3rd, this method may receive an array of additional options. All possible and valid
     * options are described in type class or base type class (ex emailEmailType::class, StringType::class, BaseType::class)
     * and depends on string type format. All class type properties may be received in options array. Method will return
     * an processed string.
     *
     * @param string $value   - Value to be processed to hide sensitive data with special char.
     * @param array  $options - Additional options used on processing. All options depends on string type format and
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
            case EmailType::class:
                return self::hideEmail($value, $options);
            case StringType::class:
            default:
                return self::hideString($value, $options);
        }
    }

    /**
     * Hide chars in string.
     * This method is designed to hide personal and sensitive information from simple string. Chars will be replaced
     * with special symbol. Method will return an processed string.
     *
     * @param string $value   - Value to be processed to hide sensitive data with special char.
     * @param array  $options - Additional options used on processing. All options depends on string type format and
     *                          type class.
     *
     * @return string
     */
    private static function hideString(string $value, array $options): string
    {
        $char   = $options[StringType::HIDE_CHAR_OPTION] ?? StringType::$hideChar;
        $length = $options[StringType::LENGTH_OPTION] ?? StringType::$length;
        $offset = $options[StringType::OFFSET_OPTION] ?? StringType::$offset;

        return self::replaceString($value, $length, $char, $offset);
    }

    /**
     * Hide chars in email string.
     * This method is designed to hide personal and sensitive information from email string. Chars will be replaced with
     * special symbol. Method will return an processed string.
     *
     * @param string $value   - Email value string to be processed to hide sensitive data with special char.
     * @param array  $options - Additional options used on processing. All options depends on string type format and
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
        $length = $options[EmailType::DOMAIN_LENGTH_OPTION] ?? EmailType::$domainLength;
        if (0 <= $length) {
            $offset = $options[EmailType::DOMAIN_OFFSET_OPTION] ?? EmailType::$domainOffset;
            /** Get special char to replace sensitive or personal data. Value may be received from options or default from
             * class who describe used type of string format. */
            $char = $options[EmailType::HIDE_CHAR_OPTION] ?? EmailType::$hideChar;

            $parts[1] = self::replaceString($parts[1], $length, $char, $offset);
        }


        return implode('@', $parts);
    }

    /**
     * Replace chars in string.
     * This method is designed to replace chars in string with special char. Number of chars to be changed, depends on
     * second argument $length and $value string length. First replaced char may be offset with last argument $offset.
     * Method will return an processed string.
     *
     * @param string $value  - String value to be processed and replaced chars.
     * @param int    $length - Number of chars to be replaced by special $char.
     * @param string $char   - Special symbol used to replace chars from string.
     * @param int    $offset - Offset first char to be replaced.
     *
     * @return string
     */
    private static function replaceString(string $value, int $length = 0, string $char = '*', int $offset = 0): string
    {
        if (0 === $length) {
            return $value;
        }

        if ($length + $offset > strlen($value)) {
            $length = strlen($value) - $offset;
        }

        $pattern = sprintf('/^(.{%s}).{1,%s}/', $offset, $length);
        $replace = sprintf('$1%s', str_repeat($char, $length));

        return preg_replace($pattern, $replace, $value);
    }
}
