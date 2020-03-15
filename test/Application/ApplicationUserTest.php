<?php

namespace Restest\Application;

use Restest\Domain\Repository\IRepositoryUser;
use Restest\Domain\User;

class ApplicationUserTest extends ApplicationTestCase
{
    private $userRepository;
    private $userMock;

    public function setUp()
    {
        parent::setUp();
        $this->userRepository = $this->getMockBuilder(IRepositoryUser::class)->getMock();
        $this->repository->expects($this->any())->method("forUser")->willReturn($this->userRepository);
        $this->userMock = $this->getMockBuilder(User::class)->disableOriginalConstructor()->getMock();
    }

    public function testInstance()
    {
        $this->assertTrue(ApplicationUser::instance() instanceof ApplicationUser);
    }

    /*public function testDelete()
    {
        $this->userRepository->expects($this->once())->method('delete')->with('1');

        $this->client->delete('/user/1');

        $this->assertStatusEquals(204);
    }*/

    public function testGet()
    {
        $this->userRepository
            ->expects($this->once())
            ->method("get")
            ->with(1)
            ->willReturn($this->userMock);

        $this->client->get("/user/1");

        $this->assertStatusEquals(200);
        $this->assertResultEquals($this->userPresentation());
    }

    public function testGetAll()
    {
        $this->userRepository->expects($this->once())->method("getAll")->willReturn(
            [$this->userMock]
        );

        $this->client->get("/users");

        $this->assertStatusEquals(200);
        $this->assertResultEquals([$this->userPresentation()]);
    }

    public function testPost()
    {
        $this->userRepository
            ->expects($this->once())
            ->method("add")
            ->will($this->returnArgumentWithId());

        $this->client->post("/user", ["name" => "Raj M", "email" => "test@example.com"]);

        $this->assertStatusEquals(201);
        $this->assertResultEquals([
            "id" => 1,
            "name" => "Raj M",
            "email" => "test@example.com",
            "role_id" => ""
        ]);
    }

    public function testPut()
    {
        $user = $this->getMockBuilder(User::class)->disableOriginalConstructor()->getMock();
        $user->expects($this->once())->method("setName")->with("Raj M");
        $user->expects($this->once())->method("setEmail")->with("test@example.com");
        //$user->expects($this->once())->method("setRole")->with(2);
        $user->expects($this->once())->method("getId")->willReturn(1);
        $user->expects($this->once())->method("getName")->willReturn("Raj M");
        $user->expects($this->once())->method("getEmail")->willReturn("test@example.com");
        //$user->expects($this->once())->method("getRole")->willReturn(2);

        $this->userRepository
            ->expects($this->once())
            ->method("get")
            ->with(1)
            ->willReturn($user);
        $this->userRepository
            ->expects($this->once())
            ->method("edit")
            ->with($user);

        $this->client->put("/user/1", ["name" => "Raj M", "email" => "test@example.com"]);

        $this->assertStatusEquals(201);
        $this->assertResultEquals([
            "id" => 1,
            "name" => "Raj M",
            "email" => "test@example.com",
            "role_id" => ""
        ]);
    }

    private function userPresentation()
    {
        return [
            "id" => null,
            "name" => null,
            "email" => null,
            "role_id" => null,
        ];
    }
}