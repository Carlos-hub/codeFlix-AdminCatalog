<?php

namespace Core\UseCase\DTO\Category\create;

class CategoryCreateInputDTO
{
public function __construct(
    public string $name,
    public string $description = '',
    public bool $status = true,
){}

}
