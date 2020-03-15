<?php


namespace Restest\Domain\Repository;


interface IRepositoryRole
{
    public function add($role);

    public function delete($id);

    public function edit($role);

    public function get($id);

    public function getAll();

    public function getByName($name);
}