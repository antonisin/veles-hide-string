<?php

namespace MaximAntonisin\Veles\Type;


/**
 * Email String Type interface.
 * This interface is used to define all default values and options for email string format type. Interface is used for
 * validation and to store default values.
 *
 * @author Maxim Antonisin <maxim.antonisin@gmail.com>
 *
 * @version 1.0.0
 */
interface EmailTypeInterface extends StringTypeInterface
{
    /** Constants to describe options names. */
    const OPTION_DOMAIN_LENGTH = 'domainLength';
    const OPTION_DOMAIN_OFFSET = 'domainOffset';

    /** Constants to describe default values. */
    const DEFAULT_DOMAIN_LENGTH = 0;
    const DEFAULT_DOMAIN_OFFSET = 0;
}