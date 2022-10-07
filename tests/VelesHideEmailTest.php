<?php

declare(strict_types=1);

namespace MaximAntonisin\Tests;

use MaximAntonisin\Veles\Type\EmailTypeInterface;
use MaximAntonisin\Veles\VelesHide;
use PHPUnit\Framework\TestCase;

/**
 * Veles Hide Test.
 * This class is designed to test VelesHide class.
 *
 * @author Maxim Antonisin <maxim.antonisin@gmail.com>
 *
 * @version 1.0.0
 */
class VelesHideEmailTest extends TestCase
{
    /**
     * Test hide email.
     * Method to test hide email feature.
     *
     * @dataProvider providerTestHideEmail
     *
     * @param string $value    - Value to be processed to hide sensitive data with special char.
     * @param string $expected - Expected result.
     *
     *
     * @throws \Exception
     */
    public function testHideEmail(string $value, string $expected, array $options = []): void
    {
        $this->assertEquals($expected, VelesHide::hide($value, $options, 'email'));
    }

    /**
     * Provider for testHideEmail.
     *
     * @return array
     */
    public function providerTestHideEmail(): array
    {
        return [
            "TC1" => ["f@example.com", "f@example.com"],
            "TC2" => ["foo@example.com", "f**@example.com"],
            "TC3" => ["longEmailAddressName@example.com", "l****mailAddressName@example.com"],

            "TC4 Domain-Length" => [
                "longEmailAddressName@longDomainForTesting.com",
                "l****mailAddressName@****DomainForTesting.com",
                [ EmailTypeInterface::OPTION_DOMAIN_LENGTH => 4 ],
            ],
            "TC5 Domain-Length" => [
                "longEmailAddressName@ongDomainForTesting.com",
                "l****mailAddressName@**********orTesting.com",
                [ EmailTypeInterface::OPTION_DOMAIN_LENGTH => 10],
            ],
            "TC6 Domain-Length ONLY" => [
                "longEmailAddressName@longDomainForTesting.com",
                "longEmailAddressName@****DomainForTesting.com",
                [
                    EmailTypeInterface::OPTION_DOMAIN_LENGTH => 4,
                    EmailTypeInterface::OPTION_LENGTH        => 0,
                ],
            ],

            "TC7 Domain-Offset" => [
                "longEmailAddressName@longDomainForTesting.com",
                "l****mailAddressName@long****inForTesting.com",
                [
                    EmailTypeInterface::OPTION_DOMAIN_LENGTH => 4,
                    EmailTypeInterface::OPTION_DOMAIN_OFFSET => 4
                ],
            ],
            "TC8 Domain-Offset" => [
                "longEmailAddressName@longDomainForTesting.com",
                "l****mailAddressName@longDomain****esting.com",
                [
                    EmailTypeInterface::OPTION_DOMAIN_LENGTH => 4,
                    EmailTypeInterface::OPTION_DOMAIN_OFFSET => 10
                ],
            ],
            "TC9 Domain-Offset ONLY" => [
                "longEmailAddressName@longDomainForTesting.com",
                "longEmailAddressName@long****inForTesting.com",
                [
                    EmailTypeInterface::OPTION_DOMAIN_LENGTH => 4,
                    EmailTypeInterface::OPTION_DOMAIN_OFFSET => 4,
                    EmailTypeInterface::OPTION_LENGTH        => 0,
                ],
            ],
        ];
    }
}