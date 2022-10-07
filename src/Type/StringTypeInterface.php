<?php

namespace MaximAntonisin\Veles\Type;

/**
 * String Type format interface.
 * This interface is used to define all default values and options for string type format. Interface is used in
 * validation process and to store default values. String type is used as default string type for all methods.
 *
 * @author Maxim Antonisin <maxim.antonisin@gmail.com>
 *
 * @version 1.0.0
 */
interface StringTypeInterface
{
    /** Constants to describe options names. */
    const OPTION_LENGTH      = 'length';
    const OPTION_OFFSET      = 'offset';
    const OPTION_HIDE_CHAR   = 'hideChar';
    const OPTION_HIDE_LENGTH = 'hideLength';

    /** Constants to describe default values. */
    const DEFAULT_LENGTH    = 4;
    const DEFAULT_OFFSET    = 1;
    const DEFAULT_HIDE_CHAR = '*';
}