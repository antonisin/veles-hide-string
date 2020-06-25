<?php

namespace MaximAntonisin\Veles\Type;

/**
 * Email String Type format.
 * This class is used to define all default properties and values for email string format. Class is used for validation
 * and to store default values.
 *
 * @author Maxim Antonisin <maxim.antonisin@gmail.com>
 *
 * @version 1.0.0
 */
abstract class EmailType extends BaseType
{
    /** Constants to describe options names. */
    const DOMAIN_LENGTH_OPTION = 'domainLength';
    const DOMAIN_OFFSET_OPTION = 'domainOffset';


    /**
     * Number of chars to replace in domain part.
     * This property shown how many chars must be replaced in domain string part.
     *
     * @var int
     */
    public static $domainLength = 0;

    /**
     * Number of chars to skip before replace.
     * This property shown how many chars must be offset/skipped before char replacing.
     *
     * @var int
     */
    public static $domainOffset = 0;
}
