<?php

namespace App\DTO\Output;

class DriverDTO
{
    public int $id;
    public string $name;

    public static function fromEntity(\App\Entity\Driver $driver): self
    {
        $dto = new self();
        $dto->id = $driver->getId();
        $dto->name = $driver->getFullName(); // Ou toute autre méthode appropriée

        return $dto;
    }
}