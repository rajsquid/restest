<?php

namespace Restest\Domain\Repository;

interface IRepositoryContract
{
    public function add($contract);

    public function delete($id);

    public function edit($contract);

    public function get($id);

    public function getAll();

    public function getByName($name);
}