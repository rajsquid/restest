<?php

namespace Restest\Domain;

class UserTest extends \PHPUnit\Framework\TestCase
{
    public function testConstruct()
    {
        $user = new User("Raj M", "test@example.com");

        $this->assertEquals("Raj M", $user->getName());
    }

    /**
     * @expectedException \Restest\Domain\Error\ErrorParameter
     * @expectedExceptionMessage The user name is mandatory.
     */
    public function testConstructThrowErrorIfNameIsEmpty()
    {
        new User("", "test@example.com");
    }

    /**
     * @expectedException \Restest\Domain\Error\ErrorParameter
     * @expectedExceptionMessage The user email is mandatory.
     */
    public function testConstructThrowErrorIfEmailIsEmpty()
    {
        new User("Raj M", "");
    }

    public function testGetAndSetName()
    {
        $user = new User("Manti", "test@example.com");
        $this->assertEquals("Manti", $user->getName());

        $user->setName("Raj M");
        $this->assertEquals("Raj M", $user->getName());
    }

    /**
     * @expectedException \Restest\Domain\Error\ErrorParameter
     * @expectedExceptionMessage The user name is mandatory.
     */
    public function testSetNameThrowErrorIfNull()
    {
        $user = new User("Raj M", "test@example.com");
        $user->setName("");
    }

    public function testGetAndSetEmail()
    {
        $user = new User("Manti", "test@example.com");
        $this->assertEquals("test@example.com", $user->getEmail());

        $user->setEmail("new@example.com");
        $this->assertEquals("new@example.com", $user->getEmail());
    }

    /**
     * @expectedException \Restest\Domain\Error\ErrorParameter
     * @expectedExceptionMessage The user email is mandatory.
     */
    public function testSetEmailThrowErrorIfNull()
    {
        $user = new User("Raj M", "test@example.com");
        $user->setEmail("");
    }
}