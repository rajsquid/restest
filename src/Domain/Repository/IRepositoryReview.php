<?php

namespace Restest\Domain\Repository;

interface IRepositoryReview
{
    public function add($review);

    public function delete($id);

    public function edit($review);

    public function get($id);

    public function getAll();

    public function getByName($name);
}