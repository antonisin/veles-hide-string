<?php

namespace MaximAntonisin\Veles\Type;

/**
 * Base String Type format.
 * This class is used to define all default properties and values for base string type format. Class is used for all
 * types and for default type. Also this class is used as reference and parent for another types of string.
 *
 * @author Maxim Antonisin <maxim.antonisin@gmail.com>
 *
 * @version 1.0.0
 */
abstract class BaseType
{
    /** Constants to describe options names. */
    const LENGTH_OPTION    = 'length';
    const OFFSET_OPTION    = 'offset';
    const HIDE_CHAR_OPTION = 'hideChar';


    /**
     * Special symbol to replace char.
     * This property contain an special symbol used to replace chars in string.
     *
     * @var string
     */
    public static $hideChar = '*';

    /**
     * Number of chars to be replaced.
     * This property shown how many chars must be replaced in string.
     *
     * @var int
     */
    public static $length = 4;

    /**
     * First replace char offset.
     * This property show how many chars must be offset/skipped before char replacing.
     *
     * @var int
     */
    public static $offset = 1;
}
