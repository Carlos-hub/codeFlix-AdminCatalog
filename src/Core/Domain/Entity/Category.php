<?php

namespace Core\Domain\Entity;

use DateTime;
use Core\Domain\Entity\Traits\MethodsMagicsTraits;
use Core\Domain\Exception\EntityValidationException;
use Core\Domain\Validation\DomainValidation;
use Core\Domain\ValueObject\Uuid;

class Category
{
    use MethodsMagicsTraits;

    /**
     * @throws EntityValidationException
     * @throws \Exception
     */
    public function __construct(
        protected string $name,
        protected Uuid | string $id = '',
        protected string $description = '',
        protected bool $isActive = true,
        protected DateTime | string $createdAt = '',
    ) {
        $this->id = $this->id ? new Uuid($this->id) : Uuid::random();
        $this->createdAt = $this->createdAt ? new DateTime($this->createdAt) : new DateTime();
        $this->validate();
    }

    public function activated():void
    {
        $this->isActive = true;
    }

    public function disabled():void
    {
        $this->isActive = false;
    }

    public function update(string $name = null, string $description = null):void
    {
        $this->name = $name ?? $this->name;
        $this->description = $description ?? $this->description;
        $this->validate();
    }

    /**
     * @throws EntityValidationException
     */
    private function validate()
    {
        DomainValidation::notNull($this->name, 'Name is required');
        DomainValidation::strMinLength($this->name, 3, 'Name should not be less than 3');
        DomainValidation::strMaxLength($this->description, 255, 'Name should not be greater than 255');
    }

}
