<?php

namespace Restest\Domain;


class RoleTest extends \PHPUnit\Framework\TestCase
{
    public function testConstruct()
    {
        $role = new Role("Editor");

        $this->assertEquals("Editor", $role->getName());
    }

    /**
     * @expectedException \Restest\Domain\Error\ErrorParameter
     * @expectedExceptionMessage The role name is mandatory.
     */
    public function testConstructThrowErrorIfNameIsEmpty()
    {
        new Role("");
    }

    public function testGetAndSetName()
    {
        $role = new Role("Editor");
        $this->assertEquals("Editor", $role->getName());

        $role->setName("Editor");
        $this->assertEquals("Editor", $role->getName());
    }

    /**
     * @expectedException \Restest\Domain\Error\ErrorParameter
     * @expectedExceptionMessage The role name is mandatory.
     */
    public function testSetNameThrowErrorIfNull()
    {
        $role = new Role("Editor");
        $role->setName("");
    }
}
