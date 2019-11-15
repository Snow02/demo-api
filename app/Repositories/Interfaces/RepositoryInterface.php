<?php

namespace App\Repositories\Interfaces;

interface RepositoryInterface
{
    public function selectAll();
    public function find($id);
    public function create(array $attributes);
    public function  update($id, array $attributes);
    public function  delete($id);
}