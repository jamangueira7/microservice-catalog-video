<?php

namespace Core\UseCase\DTO\Category;

class ListCategoriesOutputDto
{
    public function __construct(
        public array $items,
        public string $total,
        public int $last_page,
        public int $first_page,
        public int $current_page,
        public int $per_page,
        public int $to,
        public int $from,
    ) {}
}