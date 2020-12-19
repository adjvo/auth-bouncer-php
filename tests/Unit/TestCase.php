<?php

namespace AdjvoAuthBouncer\Test\Unit;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class TestCase extends PHPUnitTestCase
{
    /**
     * @param $object
     * @param $name
     * @param $value
     * @param null $args
     * @return void
     */
    protected function assertObjectMethod($object, $name, $value, $args = null): void
    {
        // Arrange
        $that = $this;

        $assertPropertyClosure = function () use ($that, $name, $args, $value)
        {
            $result = $args ? $this->$name($args) : $this->$name();

            $that->assertEquals($value, $result);
        };

        $doAssertPropertyClosure = $assertPropertyClosure->bindTo($object, get_class($object));

        // Assert
        $doAssertPropertyClosure();
    }

    /**
     * @param $object
     * @param $name
     * @param $value
     */
    protected function assertObjectProperty($object, $name, $value): void
    {
        // Arrange
        $that = $this;

        $assertPropertyClosure = function () use ($that, $name, $value)
        {
            $that->assertEquals($value, $this->$name);
        };

        $doAssertPropertyClosure = $assertPropertyClosure->bindTo($object, get_class($object));

        // Assert
        $doAssertPropertyClosure();
    }

    /**
     * @param $object
     * @param $name
     * @param $value
     */
    protected function assertObjectPropertySize($object, $name, $value): void
    {
        // Arrange
        $that = $this;

        $assertPropertyClosure = function () use ($that, $name, $value)
        {
            $size = count($this->$name);

            $that->assertEquals($value, $size);
        };

        $doAssertPropertyClosure = $assertPropertyClosure->bindTo($object, get_class($object));

        // Assert
        $doAssertPropertyClosure();
    }
}
