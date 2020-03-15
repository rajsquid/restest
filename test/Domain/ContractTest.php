<?php

namespace Restest\Domain;

class ContractTest extends \PHPUnit\Framework\TestCase
{
    public function testConstruct()
    {
        $contract = new Contract("HouseContract");

        $this->assertEquals("HouseContract", $contract->getName());
    }

    /**
     * @expectedException \Restest\Domain\Error\ErrorParameter
     * @expectedExceptionMessage The contract name is mandatory.
     */
    public function testConstructThrowErrorIfNameIsEmpty()
    {
        new Contract("");
    }

    public function testGetAndSetName()
    {
        $contract = new Contract("HomeContract");
        $this->assertEquals("HomeContract", $contract->getName());

        $contract->setName("LandContract");
        $this->assertEquals("LandContract", $contract->getName());
    }

    /**
     * @expectedException \Restest\Domain\Error\ErrorParameter
     * @expectedExceptionMessage The contract name is mandatory.
     */
    public function testSetNameThrowErrorIfNull()
    {
        $contract = new Contract("SomeContract");
        $contract->setName("");
    }
}