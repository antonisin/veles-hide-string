<?php

declare(strict_types=1);

namespace MaximAntonisin\Tests;

use MaximAntonisin\Veles\Type\StringTypeInterface;
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
class VelesHideStringTest extends TestCase
{
    /**
     * Test hide string.
     * This method is designed to test hide method from VelesHide class.
     *
     * @dataProvider providerTestHideString
     *
     * @param string $value    - Value to be processed to hide sensitive data with special char.
     * @param string $expected - Expected result.
     *
     *
     * @throws \Exception
     */
    public function testHideString(string $value, string $expected, array $options = []): void
    {
        $this->assertEquals($expected, VelesHide::hide($value, $options));
    }

    /**
     * Provider for testHideString.
     *
     * @return array
     */
    public function providerTestHideString(): array
    {
        return [
            "TC1" => ["testword", "t****ord"],
            "TC2" => ["word", "w***"],
            "TC3 Hide-Char" => [
                "longTestWordUsedForTesting",
                "l????estWordUsedForTesting",
                [ StringTypeInterface::OPTION_HIDE_CHAR => '?' ],
            ],
            "TC4 Hide-Char" => [
                "longTestWordUsedForTesting",
                "l!%!%!%!%estWordUsedForTesting",
                [ StringTypeInterface::OPTION_HIDE_CHAR => '!%' ],
            ],
            "TC5 Length" => [
                "longTestWordUsedForTesting",
                "l*ngTestWordUsedForTesting",
                [ StringTypeInterface::OPTION_LENGTH => 1 ],
            ],
            "TC6 Length" => [
                "longTestWordUsedForTesting",
                "l**********dUsedForTesting",
                [ StringTypeInterface::OPTION_LENGTH => 10 ],
            ],
            "TC7 Length" => [
                "longTestWordUsedForTesting",
                "l*************************",
                [ StringTypeInterface::OPTION_LENGTH => 1000 ],
            ],
            "TC8 Offset" => [
                "longTestWordUsedForTesting",
                "lon****tWordUsedForTesting",
                [ StringTypeInterface::OPTION_OFFSET => 3 ],
            ],
            "TC9 Offset" => [
                "longTestWordUsedForTesting",
                "longTestWordUsedForTesting",
                [ StringTypeInterface::OPTION_OFFSET => 100 ],
            ],
            "TC10 Offset" => [
                "longTestWordUsedForTesting",
                "longTestWordUsedForTesting",
                [ StringTypeInterface::OPTION_OFFSET => 26 ],
            ],
            "TC10 Hide-Length" => [
                "longTestWordUsedForTesting",
                "l*estWordUsedForTesting",
                [ StringTypeInterface::OPTION_HIDE_LENGTH => true ],
            ],
            "TC11 ALL" => [
                "longTestWordUsedForTesting",
                "longTestWo?rTesting",
                [
                    StringTypeInterface::OPTION_HIDE_CHAR => '?',
                    StringTypeInterface::OPTION_OFFSET => 10,
                    StringTypeInterface::OPTION_LENGTH => 8,
                    StringTypeInterface::OPTION_HIDE_LENGTH => true
                ],
            ],
        ];
    }

    /**
     * Test hide string with invalid options.
     * This method is designed to test hide method from VelesHide class with invalid options.
     *
     * @dataProvider providerTestHideStringException
     *
     * @param mixed  $value          - Value to be processed to hide sensitive data with special char.
     * @param mixed  $options        - Options to be used for processing.
     * @param mixed  $type           - Veles hide type.
     * @param string $exceptionClass - Expected exception class.
     *
     *
     * @throws \Exception
     */
    public function testHideStringException($value, $options, $type, string $exceptionClass = \TypeError::class): void
    {
        $this->expectException($exceptionClass);
        VelesHide::hide($value, $options, $type);
    }

    /**
     * Provider for testHideStringException.
     *
     * @return array
     */
    public function providerTestHideStringException(): array
    {
        return [
            "TC1 value" => [true, [], 'string'],
            "TC2 value" => [1, [], 'string'],
            "TC3 value" => [1.11, [], 'string'],
            "TC4 value" => [[], [], 'string'],
            "TC5 value" => [new \stdClass(), [], 'string'],

            "TC1 option" => ['testString', true, 'string'],
            "TC2 option" => ['testString', 1, 'string'],
            "TC3 option" => ['testString', 1.11, 'string'],
            "TC4 option" => ['testString', 'test', 'string'],
            "TC5 option" => ['testString', new \stdClass(), 'string'],

            "TC1 type" => ['testString', [], true],
            "TC2 type" => ['testString', [], 1],
            "TC3 type" => ['testString', [], 1.11],
            "TC4 type" => ['testString', [], []],
            "TC5 type" => ['testString', [], new \stdClass()],
            "TC6 type" => ['testString', [], 'invalidType', \Exception::class],
            "TC7 type" => ['testString', [], 'email', \Exception::class],
            "TC8 type" => ['testString', [], 'url', \Exception::class],

        ];
    }
}