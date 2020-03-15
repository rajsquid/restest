<?php

namespace Restest\Application;

use Restest\Domain\Contract;
use Restest\Domain\Repository\IRepositoryContract;

class ApplicationContractTest extends ApplicationTestCase
{
    private $contractRepository;
    private $contractMock;

    public function setUp()
    {
        parent::setUp();
        $this->contractRepository = $this->getMockBuilder(IRepositoryContract::class)->getMock();
        $this->repository->expects($this->any())->method("forContract")->willReturn($this->contractRepository);
        $this->contractMock = $this->getMockBuilder(Contract::class)->disableOriginalConstructor()->getMock();
    }

    public function testInstance()
    {
        $this->assertTrue(ApplicationContract::instance() instanceof ApplicationContract);
    }

    public function testDelete()
    {
        $this->contractRepository->expects($this->once())->method('delete')->with('1');

        $this->client->delete('/contract/1');

        $this->assertStatusEquals(204);
    }

    public function testGet()
    {
        $this->contractRepository
            ->expects($this->once())
            ->method("get")
            ->with(1)
            ->willReturn($this->contractMock);

        $this->client->get("/contract/1");

        $this->assertStatusEquals(200);
        $this->assertResultEquals($this->contractPresentation());
    }

    public function testGetAll()
    {
        $this->contractRepository->expects($this->once())->method("getAll")->willReturn(
            [$this->contractMock]
        );

        $this->client->get("/contracts");

        $this->assertStatusEquals(200);
        $this->assertResultEquals([$this->contractPresentation()]);
    }

    public function testPost()
    {
        $this->contractRepository
            ->expects($this->once())
            ->method("add")
            ->will($this->returnArgumentWithId());

        $this->client->post("/contract", ["name" => "Contract 1"]);

        $this->assertStatusEquals(201);
        $this->assertResultEquals(["id" => 1, "name" => "Contract 1", "risk_id" => ""]);
    }

    public function testPut()
    {
        $contract = $this->getMockBuilder(Contract::class)->disableOriginalConstructor()->getMock();
        $contract->expects($this->once())->method("setName")->with("Contract 1");
        $contract->expects($this->once())->method("getId")->willReturn(1);
        $contract->expects($this->once())->method("getName")->willReturn("Contract 1");

        $this->contractRepository
            ->expects($this->once())
            ->method("get")
            ->with(1)
            ->willReturn($contract);
        $this->contractRepository
            ->expects($this->once())
            ->method("edit")
            ->with($contract);

        $this->client->put("/contract/1", ["name" => "Contract 1"]);

        $this->assertStatusEquals(201);
        $this->assertResultEquals(["id" => 1, "name" => "Contract 1", "risk_id" => ""]);
    }

    private function contractPresentation()
    {
        return [
            "id" => null,
            "name" => null,
            "risk_id" => null
        ];
    }
}