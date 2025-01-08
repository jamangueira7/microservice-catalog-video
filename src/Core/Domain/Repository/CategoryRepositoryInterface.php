<?php

namespace Core\Domain\Entity;

interface CategoryRepositoryInterface
{
    public function insert(Category $category): Category;
    public function findAll(string $filter = '', $order = 'DESC'): array;
    public function findById(string $id): Category;
    public function paginate(
        string $filter = '',
        string $order = 'DESC',
        int $page = 1,
        int $totalPage = 15
    ): PaginateInterface;
    public function update(Category $category): Category;
    public function delete(string $id): bool;
    public function toCategory(object $data): Category;
}