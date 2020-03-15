<?php

namespace Restest\Application;

use Restest\Domain\Role;
use Restest\Domain\Repository\IRepositoryRole;

class ApplicationRoleTest extends ApplicationTestCase
{
    private $roleRepository;
    private $roleMock;

    public function setUp()
    {
        parent::setUp();
        $this->roleRepository = $this->getMockBuilder(IRepositoryRole::class)->getMock();
        $this->repository->expects($this->any())->method("forRole")->willReturn($this->roleRepository);
        $this->roleMock = $this->getMockBuilder(Role::class)->disableOriginalConstructor()->getMock();
    }

    public function testInstance()
    {
        $this->assertTrue(ApplicationRole::instance() instanceof ApplicationRole);
    }

    public function testDelete()
    {
        $this->roleRepository->expects($this->once())->method('delete')->with('1');

        $this->client->delete('/role/1');

        $this->assertStatusEquals(204);
    }

    public function testGet()
    {
        $this->roleRepository
            ->expects($this->once())
            ->method("get")
            ->with(1)
            ->willReturn($this->roleMock);

        $this->client->get("/role/1");

        $this->assertStatusEquals(200);
        $this->assertResultEquals($this->rolePresentation());
    }

    public function testGetAll()
    {
        $this->roleRepository->expects($this->once())->method("getAll")->willReturn(
            [$this->roleMock]
        );

        $this->client->get("/roles");

        $this->assertStatusEquals(200);
        $this->assertResultEquals([$this->rolePresentation()]);
    }

    public function testPost()
    {
        $this->roleRepository
            ->expects($this->once())
            ->method("add")
            ->will($this->returnArgumentWithId());

        $this->client->post("/role", ["name" => "Super Inc."]);

        $this->assertStatusEquals(201);
        $this->assertResultEquals(["id" => 1, "name" => "Super Inc."]);
    }

    public function testPut()
    {
        $role = $this->getMockBuilder(Role::class)->disableOriginalConstructor()->getMock();
        $role->expects($this->once())->method("setName")->with("Super Inc.");
        $role->expects($this->once())->method("getId")->willReturn(1);
        $role->expects($this->once())->method("getName")->willReturn("Super Inc.");

        $this->roleRepository
            ->expects($this->once())
            ->method("get")
            ->with(1)
            ->willReturn($role);
        $this->roleRepository
            ->expects($this->once())
            ->method("edit")
            ->with($role);

        $this->client->put("/role/1", ["name" => "Super Inc."]);

        $this->assertStatusEquals(201);
        $this->assertResultEquals(["id" => 1, "name" => "Super Inc."]);
    }

    private function rolePresentation()
    {
        return [
            "id" => null,
            "name" => null
        ];
    }
}