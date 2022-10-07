<?php

namespace MaximAntonisin\Veles\Type;

/**
 * Url String Type interface.
 * This interface is used to define all default options and values for url string format type. Interface is used for
 * validation and to store default values.
 *
 * @author Maxim Antonisin <maxim.antonisin@gmail.com>
 *
 * @version 1.0.0
 */
interface UrlTypeInterface extends StringTypeInterface
{
    /** Constants to describe options names. */
    const OPTION_SCHEME_LENGTH = 'schemeLength';
    const OPTION_SCHEME_OFFSET = 'schemeOffset';

    const OPTION_PATH_LENGTH = 'pathLength';
    const OPTION_PATH_OFFSET = 'pathOffset';

    const OPTION_QUERY_LENGTH = 'queryLength';
    const OPTION_QUERY_OFFSET = 'queryOffset';

    /** Constants to describe default values. */
    const DEFAULT_SCHEME_LENGTH = 0;
    const DEFAULT_SCHEME_OFFSET = 0;

    const DEFAULT_PATH_LENGTH = -1;
    const DEFAULT_PATH_OFFSET = 1;

    const DEFAULT_QUERY_LENGTH = -1;
    const DEFAULT_QUERY_OFFSET = 1;
}