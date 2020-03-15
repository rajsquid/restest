<?php

namespace Restest\Application;

use Restest\Domain\Repository\IRepositoryReview;
use Restest\Domain\Review;

class ApplicationReviewTest extends ApplicationTestCase
{
    private $reviewRepository;
    private $reviewMock;

    public function setUp()
    {
        parent::setUp();
        $this->reviewRepository = $this->getMockBuilder(IRepositoryReview::class)->getMock();
        $this->repository->expects($this->any())->method("forReview")->willReturn($this->reviewRepository);
        $this->reviewMock = $this->getMockBuilder(Review::class)->disableOriginalConstructor()->getMock();
    }

    public function testInstance()
    {
        $this->assertTrue(ApplicationReview::instance() instanceof ApplicationReview);
    }

    public function testDelete()
    {
        $this->reviewRepository->expects($this->once())->method('delete')->with('1');

        $this->client->delete('/review/1');

        $this->assertStatusEquals(204);
    }

    public function testGet()
    {
        $this->reviewRepository
            ->expects($this->once())
            ->method("get")
            ->with(1)
            ->willReturn($this->reviewMock);

        $this->client->get("/review/1");

        $this->assertStatusEquals(200);
        $this->assertResultEquals($this->reviewPresentation());
    }

    public function testGetAll()
    {
        $this->reviewRepository->expects($this->once())->method("getAll")->willReturn(
            [$this->reviewMock]
        );

        $this->client->get("/reviews");

        $this->assertStatusEquals(200);
        $this->assertResultEquals([$this->reviewPresentation()]);
    }

    public function testPost()
    {
        $this->reviewRepository
            ->expects($this->once())
            ->method("add")
            ->will($this->returnArgumentWithId());

        $this->client->post("/review", ["name" => "TestReview", "description" => "Test Description"]);

        $this->assertStatusEquals(201);
        $this->assertResultEquals([
            "id" => 1,
            "name" => "TestReview",
            "description" => "Test Description"
        ]);
    }

    public function testPut()
    {
        $review = $this->getMockBuilder(Review::class)->disableOriginalConstructor()->getMock();
        $review->expects($this->once())->method("setName")->with("TestReview");
        $review->expects($this->once())->method("setDesc")->with("Test Description");
        //$user->expects($this->once())->method("setRole")->with(2);
        $review->expects($this->once())->method("getId")->willReturn(1);
        $review->expects($this->once())->method("getName")->willReturn("TestReview");
        $review->expects($this->once())->method("getDesc")->willReturn("Test Description");
        //$user->expects($this->once())->method("getRole")->willReturn(2);

        $this->reviewRepository
            ->expects($this->once())
            ->method("get")
            ->with(1)
            ->willReturn($review);
        $this->reviewRepository
            ->expects($this->once())
            ->method("edit")
            ->with($review);

        $this->client->put("/review/1", ["name" => "TestReview", "description" => "Test Description"]);

        $this->assertStatusEquals(201);
        $this->assertResultEquals([
            "id" => 1,
            "name" => "TestReview",
            "description" => "Test Description",
        ]);
    }

    private function reviewPresentation()
    {
        return [
            "id" => null,
            "name" => null,
            "description" => null,
        ];
    }
}