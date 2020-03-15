<?php


namespace Restest\Domain\Repository;


interface IRepositoryRisk
{
    public function add($risk);

    public function delete($id);

    public function edit($risk);

    public function get($id);

    public function getAll();

    public function getByName($name);
}