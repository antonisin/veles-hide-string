<?php

declare(strict_types=1);

namespace MaximAntonisin\Tests;

use MaximAntonisin\Veles\Type\UrlTypeInterface;
use PHPUnit\Framework\TestCase;
use MaximAntonisin\Veles\VelesHide;

/**
 * Veles Hide Url Test.
 * This class is designed to test VelesHide class for url type.
 *
 * @author Maxim Antonisin <maxim.antonisin@gmail.com>
 *
 * @version 1.0.0
 */
class VelesHideUrlTest extends TestCase
{
    /**
     * Test hide url.
     * This method is designed to test hide method from VelesHide class.
     *
     * @dataProvider providerTestHideUrl
     *
     * @param string $value    - Value to be processed to hide sensitive data with special char.
     * @param string $expected - Expected result.
     *
     *
     * @throws \Exception
     */
    public function testHideUrl(string $value, string $expected, array $options = []): void
    {
        $this->assertEquals($expected, VelesHide::hide($value, $options, 'url'));
    }

    /**
     * Provider for test hide url.
     * This method is designed to provide data for test hide url.
     *
     * @return array
     */
    public function providerTestHideUrl(): array
    {
        return [
            "TC1" => ["https://example.com", "https://e****le.com"],
            "TC2 www" => ["https://www.example.com", "https://w****xample.com"],
            "TC3 subdomain" => ["https://foo.example.com", "https://f****xample.com"],
            "TC4 http" => ["http://example.com", "http://e****le.com"],
            "TC5 https" => ["https://example.com", "https://e****le.com"],
            "TC6" => ["https://example.com:443", "https://e****le.com:443"],
            "TC7 path" => ["https://example.com/path/to/something", "https://e****le.com"],
            "TC8 path" => [
                "https://example.com/path/to/something",
                "https://e****le.com/path/to/something", [
                    UrlTypeInterface::OPTION_PATH_LENGTH => 0,
                ],
            ],
            "TC9 path" => [
                "https://example.com/path/to/something",
                "https://e****le.com/*****to/something", [
                    UrlTypeInterface::OPTION_PATH_LENGTH => 5,
                ],
            ],
            "TC10 path offset" => [
                "https://example.com/path/to/something",
                "https://e****le.com/path/to/s*****ing", [
                    UrlTypeInterface::OPTION_PATH_LENGTH => 5,
                    UrlTypeInterface::OPTION_PATH_OFFSET => 10,
                ],
            ],
            "TC11 query" => [
                "https://example.com/?foo=bar&baz=qux",
                "https://e****le.com?f*****r&baz=qux", [
                    UrlTypeInterface::OPTION_QUERY_LENGTH => 5,
                ],
            ],
            "TC12 query offset" => [
                "https://example.com/?foo=bar&baz=quxx",
                "https://e****le.com?foo=bar&ba*****x", [
                    UrlTypeInterface::OPTION_QUERY_LENGTH => 5,
                    UrlTypeInterface::OPTION_QUERY_OFFSET => 10,
                ],
            ],
            "TC13 schema" => [
                "https://example.com",
                "**tps://e****le.com", [
                    UrlTypeInterface::OPTION_SCHEME_LENGTH => 2,
                ],
            ],
            "TC14 schema full" => [
                "https://example.com",
                "e****le.com", [
                    UrlTypeInterface::OPTION_SCHEME_LENGTH => -1,
                ],
            ],
            "TC15 schema offset" => [
                "https://example.com",
                "h**ps://e****le.com", [
                    UrlTypeInterface::OPTION_SCHEME_LENGTH => 2,
                    UrlTypeInterface::OPTION_SCHEME_OFFSET => 1,
                ],
            ],
        ];
    }
}