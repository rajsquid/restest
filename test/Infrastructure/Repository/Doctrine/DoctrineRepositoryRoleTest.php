<?php

namespace Restest\Infrastructure\Repository\Doctrine;

use Restest\Domain\Role;


class DoctrineRepositoryRoleTest extends DoctrineRepositoryTestCase
{
    private $roleRepository;

    /**
     * @expectedException \Restest\Domain\Error\ErrorParameter
     * @expectedExceptionMessage Impossible to add empty Restest\Domain\Role.
     */
    public function testAddThrowExceptionIfNull()
    {
        $this->roleRepository->add(null);
    }

    public function testAdd()
    {
        $role = new Role("testrole123");

        $this->roleRepository->add($role);

        $result = $this->roleRepository->get($role->getId());

        $this->assertEquals($role, $result);
    }

    /**
     * @expectedException \Restest\Domain\Error\ErrorParameter
     * @expectedExceptionMessage Impossible to edit empty Restest\Domain\Role.
     */
    public function testEditThrowErrorIfNull()
    {
        $this->roleRepository->edit(null);
    }

    public function testEdit()
    {
        $role = new Role("Moderator");
        $this->persistInDatabase($role);

        $role->setName("Moderator");
        $this->roleRepository->edit($role);

        $result = $this->roleRepository->get($role->getId());

        $this->assertEquals($role, $result);
    }

    /**
     * @expectedException \Restest\Domain\Error\ErrorParameter
     * @expectedExceptionMessage Impossible to get Restest\Domain\Role with empty id.
     */
    public function testGetThrowErrorIfNull()
    {
        $this->roleRepository->get(null);
    }

    /**
     * @expectedException \Restest\Domain\Error\ErrorEntityNotFound
     * @expectedExceptionMessage Impossible to get Restest\Domain\Role with id: 9999.
     */
    public function testThrowErrorIfIdNotExist()
    {
        $this->roleRepository->get(9999);
    }

    public function testGet()
    {
        $role = new Role("Cleaner");
        $this->persistInDatabase($role);

        $result = $this->roleRepository->get($role->getId());

        $this->assertEquals($role, $result);
    }

    public function testGetByName()
    {
        $role = new Role("Superadmin");
        $this->persistInDatabase($role);

        $result = $this->roleRepository->getByName($role->getName());

        $this->assertEquals([$role], $result);
    }

    public function testGetAll()
    {
        $this->persistInDatabase(new Role("Testrole"));
        $result = $this->roleRepository->getAll();

        $this->assertTrue(is_array($result));
        $this->assertTrue($result[0] instanceof Role);
    }

    protected function setUp()
    {
        parent::setUp();
        $this->roleRepository = new DoctrineRepositoryRole($this->entityManager);
    }
}
