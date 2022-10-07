<?php

declare(strict_types=1);

namespace MaximAntonisin\Tests;

use MaximAntonisin\Veles\Type\StringTypeInterface;
use MaximAntonisin\Veles\VelesHideFilter;
use MaximAntonisin\Veles\VelesHideFunction;
use PHPUnit\Framework\TestCase;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * Veles Hide Integration Test.
 * This class is designed to test VelesHide class integration.
 *
 * @author Maxim Antonisin <maxim.antonisin@gmail.com>
 *
 * @version 1.0.0
 */
class VelesHideIntegrationTest extends TestCase
{
    /**
     * Integration test hide twig filter.
     * This method is used for integration test for filter extensions.
     *
     * @dataProvider providerVelesHideIntegrationTest
     */
    public function testVelesHideIntegrationTest($class): void
    {
        $extension = new $class();

        /** Check number of filters/functions. */
        if (VelesHideFilter::class === $class) {
            $collection = $extension->getFilters();
        } else {
            $collection = $extension->getFunctions();
        }
        $this->assertCount(3, $collection);

        /** Check if filters are extended and defined in right way. */
        foreach ($collection as $item) {
            if (VelesHideFilter::class === $class) {
                $this->assertInstanceOf(TwigFilter::class, $item);
                continue;
            }

            $this->assertInstanceOf(TwigFunction::class, $item);
        }

        /** Check if filter can be called. */
        foreach ($collection as $item) {
            list($class, $method) = $item->getCallable();

            $this->assertEquals('t****tring', $class::$method('testString'));
            /** Check url type. */
            $this->assertEquals(
                'https://t****tring.example.com',
                $class::$method('https://testString.example.com', [], 'url')
            );

            /** Check email type */
            $this->assertEquals(
                't****mail@example.com',
                $class::$method('testEmail@example.com', [], 'email')
            );

            /** Check options type */
            $this->assertEquals(
                't**********ongDummy',
                $class::$method('testStringLongDummy', [StringTypeInterface::OPTION_LENGTH => 10])
            );
        }

        /** Check names of filters. */
        $collection = array_map(function ($item) {
            return $item->getName();
        }, $collection);
        $this->assertEquals(['hide', 'stringHide', 'velesHide'], $collection);
    }

    /**
     * Data provider for testVelesHideIntegrationTest.
     *
     * @return array
     */
    public function providerVelesHideIntegrationTest(): array
    {
        return [
            [VelesHideFilter::class],
            [VelesHideFunction::class]
        ];
    }
}