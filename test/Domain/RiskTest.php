<?php

namespace Restest\Domain;


class RiskTest extends \PHPUnit\Framework\TestCase
{
    public function testConstruct()
    {
        $risk = new Risk("Severe");

        $this->assertEquals("Severe", $risk->getName());
    }

    /**
     * @expectedException \Restest\Domain\Error\ErrorParameter
     * @expectedExceptionMessage The risk name is mandatory.
     */
    public function testConstructThrowErrorIfNameIsEmpty()
    {
        new Risk("");
    }

    public function testGetAndSetName()
    {
        $risk = new Risk("Severe");
        $this->assertEquals("Severe", $risk->getName());

        $risk->setName("Severe");
        $this->assertEquals("Severe", $risk->getName());
    }

    /**
     * @expectedException \Restest\Domain\Error\ErrorParameter
     * @expectedExceptionMessage The risk name is mandatory.
     */
    public function testSetNameThrowErrorIfNull()
    {
        $risk = new Risk("Severe");
        $risk->setName("");
    }
}
