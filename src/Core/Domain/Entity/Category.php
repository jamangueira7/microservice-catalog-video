<?php

namespace Core\Domain\Entity;

use Core\Domain\Entity\Traits\MethodsMagicsTrait;
use Core\Domain\Validation\DomainValidation;
use Core\Domain\ValueObject\Uuid;
use DateTime;

class Category
{
    use MethodsMagicsTrait;
    public function __construct(
        protected Uuid|string $id = '',
        protected string $name = '',
        protected string $description = '',
        protected bool $isActive = true,
        protected DateTime|string $createAt = '',
    ) {
        $this->id = $this->id ? new Uuid($this->id) : Uuid::random();
        $this->createAt = $this->createAt ? new DateTime($this->createAt) : new DateTime();
        $this->validate();
    }

    public function activate(): void
    {
        $this->isActive = true;
    }

    public function disable(): void
    {
        $this->isActive = false;
    }

    public function update(string $name, string $description): void
    {
        $this->name = $name;
        $this->description = $description;

        $this->validate();
    }

    private function validate()
    {
        DomainValidation::notNull($this->name);
        DomainValidation::strMaxLength($this->name);
        DomainValidation::strMinLength($this->name, 3);
        DomainValidation::strCanNullMaxLength($this->description);
    }
}
