<?php

namespace Restest\Domain\Repository;

interface IRepositoryProcess
{
    public function add($process);

    public function delete($id);

    public function edit($process);

    public function get($id);

    public function getAll();

    public function getByName($name);
}