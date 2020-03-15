<?php

namespace Restest\Domain;

class ReviewTest extends \PHPUnit\Framework\TestCase
{
    public function testConstruct()
    {
        $review = new Review("TestReview", "Some description");

        $this->assertEquals("TestReview", $review->getName());
    }

    /**
     * @expectedException \Restest\Domain\Error\ErrorParameter
     * @expectedExceptionMessage The review name is mandatory.
     */
    public function testConstructThrowErrorIfNameIsEmpty()
    {
        new Review("", "Some description");
    }

    public function testGetAndSetName()
    {
        $review = new Review("TestName", "Test Description");
        $this->assertEquals("TestName", $review->getName());

        $review->setName("TestName");
        $this->assertEquals("TestName", $review->getName());
    }

    /**
     * @expectedException \Restest\Domain\Error\ErrorParameter
     * @expectedExceptionMessage The review name is mandatory.
     */
    public function testSetNameThrowErrorIfNull()
    {
        $review = new Review("TestName", "Test Description");
        $review->setName("");
    }

    public function testGetAndSetDescription()
    {
        $review = new Review("TestName", "Test Description");
        $this->assertEquals("Test Description", $review->getDesc());

        $review->setDesc("Test Description");
        $this->assertEquals("Test Description", $review->getDesc());
    }
}