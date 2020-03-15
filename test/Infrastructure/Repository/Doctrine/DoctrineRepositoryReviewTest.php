<?php

namespace Restest\Infrastructure\Repository\Doctrine;

use Restest\Domain\Review;

class DoctrineRepositoryReviewTest extends DoctrineRepositoryTestCase
{
    private $reviewRepository;

    /**
     * @expectedException \Restest\Domain\Error\ErrorParameter
     * @expectedExceptionMessage Impossible to add empty Restest\Domain\Review.
     */
    public function testAddThrowExceptionIfNull()
    {
        $this->reviewRepository->add(null);
    }

    public function testAdd()
    {
        $review = new Review("TestReview", "Some description");

        $this->reviewRepository->add($review);

        $result = $this->reviewRepository->get($review->getId());

        $this->assertEquals($review, $result);
    }

    /**
     * @expectedException \Restest\Domain\Error\ErrorParameter
     * @expectedExceptionMessage Impossible to edit empty Restest\Domain\Review.
     */
    public function testEditThrowErrorIfNull()
    {
        $this->reviewRepository->edit(null);
    }

    public function testEdit()
    {
        $review = new Review("TestReview", "Some description");
        $this->persistInDatabase($review);

        $review->setName("TestReview");
        $this->reviewRepository->edit($review);

        $result = $this->reviewRepository->get($review->getId());

        $this->assertEquals($review, $result);
    }

    /**
     * @expectedException \Restest\Domain\Error\ErrorParameter
     * @expectedExceptionMessage Impossible to get Restest\Domain\Review with empty id.
     */
    public function testGetThrowErrorIfNull()
    {
        $this->reviewRepository->get(null);
    }

    /**
     * @expectedException \Restest\Domain\Error\ErrorEntityNotFound
     * @expectedExceptionMessage Impossible to get Restest\Domain\Review with id: 9999.
     */
    public function testThrowErrorIfIdNotExist()
    {
        $this->reviewRepository->get(9999);
    }

    public function testGet()
    {
        $review = new Review("TestReview", "Some description");
        $this->persistInDatabase($review);

        $result = $this->reviewRepository->get($review->getId());

        $this->assertEquals($review, $result);
    }

    public function testGetByName()
    {
        $review = new Review("TestReview", "Some description");
        $this->persistInDatabase($review);

        $result = $this->reviewRepository->getByName($review->getName());

        $this->assertEquals([$review], $result);
    }

    public function testGetAll()
    {
        $this->persistInDatabase(new Review("TestReview", "Some description"));
        $result = $this->reviewRepository->getAll();

        $this->assertTrue(is_array($result));
        $this->assertTrue($result[0] instanceof Review);
    }

    protected function setUp()
    {
        parent::setUp();
        $this->reviewRepository = new DoctrineRepositoryReview($this->entityManager);
    }
}