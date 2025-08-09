<?php

namespace App\Interface;

interface CategoryRepositoryInterface
{
    public function index(array $filters = []);
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
