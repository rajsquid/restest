<?php

namespace Restest\Infrastructure\Repository\Doctrine;

use Restest\Domain\Risk;


class DoctrineRepositoryRiskTest extends DoctrineRepositoryTestCase
{
    private $riskRepository;

    /**
     * @expectedException \Restest\Domain\Error\ErrorParameter
     * @expectedExceptionMessage Impossible to add empty Restest\Domain\Risk.
     */
    public function testAddThrowExceptionIfNull()
    {
        $this->riskRepository->add(null);
    }

    public function testAdd()
    {
        $risk = new Risk("Testrisk123");

        $this->riskRepository->add($risk);

        $result = $this->riskRepository->get($risk->getId());

        $this->assertEquals($risk, $result);
    }

    /**
     * @expectedException \Restest\Domain\Error\ErrorParameter
     * @expectedExceptionMessage Impossible to edit empty Restest\Domain\Risk.
     */
    public function testEditThrowErrorIfNull()
    {
        $this->riskRepository->edit(null);
    }

    public function testEdit()
    {
        $risk = new Risk("Test321");
        $this->persistInDatabase($risk);

        $risk->setName("New Test321");
        $this->riskRepository->edit($risk);

        $result = $this->riskRepository->get($risk->getId());

        $this->assertEquals($risk, $result);
    }

    /**
     * @expectedException \Restest\Domain\Error\ErrorParameter
     * @expectedExceptionMessage Impossible to get Restest\Domain\Risk with empty id.
     */
    public function testGetThrowErrorIfNull()
    {
        $this->riskRepository->get(null);
    }

    /**
     * @expectedException \Restest\Domain\Error\ErrorEntityNotFound
     * @expectedExceptionMessage Impossible to get Restest\Domain\Risk with id: 9999.
     */
    public function testThrowErrorIfIdNotExist()
    {
        $this->riskRepository->get(9999);
    }

    public function testGet()
    {
        $risk = new Risk("low");
        $this->persistInDatabase($risk);

        $result = $this->riskRepository->get($risk->getId());

        $this->assertEquals($risk, $result);
    }

    public function testGetByName()
    {
        $risk = new Risk("Medium");
        $this->persistInDatabase($risk);

        $result = $this->riskRepository->getByName($risk->getName());

        $this->assertEquals([$risk], $result);
    }

    public function testGetAll()
    {
        $this->persistInDatabase(new Risk("Risktest"));
        $result = $this->riskRepository->getAll();

        $this->assertTrue(is_array($result));
        $this->assertTrue($result[0] instanceof Risk);
    }

    protected function setUp()
    {
        parent::setUp();
        $this->riskRepository = new DoctrineRepositoryRisk($this->entityManager);
    }
}
