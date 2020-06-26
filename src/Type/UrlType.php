<?php

namespace MaximAntonisin\Veles\Type;

/**
 * Url String Type format.
 * This class is used to define all default properties and values for url string format. Class is used for validation
 * and to store default values.
 *
 * @author Maxim Antonisin <maxim.antonisin@gmail.com>
 *
 * @version 1.0.0
 */
abstract class UrlType extends BaseType
{
    /** Constants to describe options names. */
    const SCHEME_LENGTH_OPTION = 'schemeLength';
    const SCHEME_OFFSET_OPTION = 'schemeOffset';

    const PATH_LENGTH_OPTION = 'pathLength';
    const PATH_OFFSET_OPTION = 'pathOffset';

    const QUERY_LENGTH_OPTION = 'queryLength';
    const QUERY_OFFSET_OPTION = 'queryOffset';


    /**
     * Number of chars to be replaced scheme.
     * This property shown how many chars must be replaced in scheme string part.
     *
     * @var int
     */
    public static $schemeLength = 0;

    /**
     * Number of chars to skip before replace.
     * This property shown how many chars must be offset/skipped before char replacing in scheme part.
     *
     * @var int
     */
    public static $schemeOffset = 0;

    /**
     * Number of chars to be replaced path.
     * This property shown how many chars must be replaced in path string part.
     *
     * @var int
     */
    public static $pathLength = -1;

    /**
     * Number of chars to skip before replace.
     * This property shown how many chars must be offset/skipped before char replacing in path part.
     *
     * @var int
     */
    public static $pathOffset = 1;

    /**
     * Number of chars to be replaced query.
     * This property shown how many chars must be replaced in path string query.
     *
     * @var int
     */
    public static $queryLength = -1;

    /**
     * Number of chars to skip before replace.
     * This property shown how many chars must be offset/skipped before char replacing in query part.
     *
     * @var int
     */
    public static $queryOffset = 1;

}
