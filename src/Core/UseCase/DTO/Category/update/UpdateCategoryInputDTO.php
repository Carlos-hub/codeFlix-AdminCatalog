<?php

namespace Core\UseCase\DTO\Category\update;

class UpdateCategoryInputDTO
{
    public function __construct(
        public string  $id,
        public string  $name,
        public ?string $description = null,
        public bool $isActive = true,
    )
    {
    }
}
