<?php

namespace Restest\Application;

use Restest\Domain\Risk;
use Restest\Domain\Repository\IRepositoryRisk;

class ApplicationRiskTest extends ApplicationTestCase
{
    private $riskRepository;
    private $riskMock;

    public function setUp()
    {
        parent::setUp();
        $this->riskRepository = $this->getMockBuilder(IRepositoryRisk::class)->getMock();
        $this->repository->expects($this->any())->method("forRisk")->willReturn($this->riskRepository);
        $this->riskMock = $this->getMockBuilder(Risk::class)->disableOriginalConstructor()->getMock();
    }

    public function testInstance()
    {
        $this->assertTrue(ApplicationRisk::instance() instanceof ApplicationRisk);
    }

    public function testDelete()
    {
        $this->riskRepository->expects($this->once())->method('delete')->with('1');

        $this->client->delete('/risk/1');

        $this->assertStatusEquals(204);
    }

    public function testGet()
    {
        $this->riskRepository
            ->expects($this->once())
            ->method("get")
            ->with(1)
            ->willReturn($this->riskMock);

        $this->client->get("/risk/1");

        $this->assertStatusEquals(200);
        $this->assertResultEquals($this->riskPresentation());
    }

    public function testGetAll()
    {
        $this->riskRepository->expects($this->once())->method("getAll")->willReturn(
            [$this->riskMock]
        );

        $this->client->get("/risks");

        $this->assertStatusEquals(200);
        $this->assertResultEquals([$this->riskPresentation()]);
    }

    public function testPost()
    {
        $this->riskRepository
            ->expects($this->once())
            ->method("add")
            ->will($this->returnArgumentWithId());

        $this->client->post("/risk", ["name" => "Severe"]);

        $this->assertStatusEquals(201);
        $this->assertResultEquals(["id" => 1, "name" => "Severe"]);
    }

    public function testPut()
    {
        $risk = $this->getMockBuilder(Risk::class)->disableOriginalConstructor()->getMock();
        $risk->expects($this->once())->method("setName")->with("Severe Test");
        $risk->expects($this->once())->method("getId")->willReturn(1);
        $risk->expects($this->once())->method("getName")->willReturn("Severe Test");

        $this->riskRepository
            ->expects($this->once())
            ->method("get")
            ->with(1)
            ->willReturn($risk);
        $this->riskRepository
            ->expects($this->once())
            ->method("edit")
            ->with($risk);

        $this->client->put("/risk/1", ["name" => "Severe Test"]);

        $this->assertStatusEquals(201);
        $this->assertResultEquals(["id" => 1, "name" => "Severe Test"]);
    }

    private function riskPresentation()
    {
        return [
            "id" => null,
            "name" => null
        ];
    }
}