<?php

namespace Restest\Infrastructure\Repository\Doctrine;

use Restest\Domain\Contract;

class DoctrineRepositoryContractTest extends DoctrineRepositoryTestCase
{
    private $contractRepository;

    /**
     * @expectedException \Restest\Domain\Error\ErrorParameter
     * @expectedExceptionMessage Impossible to add empty Restest\Domain\Contract.
     */
    public function testAddThrowExceptionIfNull()
    {
        $this->contractRepository->add(null);
    }

    public function testAdd()
    {
        $contract = new Contract("HouseContract");

        $this->contractRepository->add($contract);

        $result = $this->contractRepository->get($contract->getId());

        $this->assertEquals($contract, $result);
    }

    /**
     * @expectedException \Restest\Domain\Error\ErrorParameter
     * @expectedExceptionMessage Impossible to edit empty Restest\Domain\Contract.
     */
    public function testEditThrowErrorIfNull()
    {
        $this->contractRepository->edit(null);
    }

    public function testEdit()
    {
        $contract = new Contract("HouseContract");
        $this->persistInDatabase($contract);

        $contract->setName("HouseContract");
        $this->contractRepository->edit($contract);

        $result = $this->contractRepository->get($contract->getId());

        $this->assertEquals($contract, $result);
    }

    /**
     * @expectedException \Restest\Domain\Error\ErrorParameter
     * @expectedExceptionMessage Impossible to get Restest\Domain\Contract with empty id.
     */
    public function testGetThrowErrorIfNull()
    {
        $this->contractRepository->get(null);
    }

    /**
     * @expectedException \Restest\Domain\Error\ErrorEntityNotFound
     * @expectedExceptionMessage Impossible to get Restest\Domain\Contract with id: 9999.
     */
    public function testThrowErrorIfIdNotExist()
    {
        $this->contractRepository->get(9999);
    }

    public function testGet()
    {
        $contract = new Contract("LandContract");
        $this->persistInDatabase($contract);

        $result = $this->contractRepository->get($contract->getId());

        $this->assertEquals($contract, $result);
    }

    public function testGetByName()
    {
        $contract = new Contract("LandContract V1");
        $this->persistInDatabase($contract);

        $result = $this->contractRepository->getByName($contract->getName());

        $this->assertEquals([$contract], $result);
    }

    public function testGetAll()
    {
        $this->persistInDatabase(new Contract("LandContract V1"));
        $result = $this->contractRepository->getAll();

        $this->assertTrue(is_array($result));
        $this->assertTrue($result[0] instanceof Contract);
    }

    protected function setUp()
    {
        parent::setUp();
        $this->contractRepository = new DoctrineRepositoryContract($this->entityManager);
    }
}