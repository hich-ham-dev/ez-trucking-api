<?php

namespace App\DTO\Output;

class VehicleDTO
{
    public int $id;
    public string $licensePlate;
    public string $model;

    public static function fromEntity(\App\Entity\Vehicle $vehicle): self
    {
        $dto = new self();
        $dto->id = $vehicle->getId();
        $dto->licensePlate = $vehicle->getLicensePlate();
        $dto->model = $vehicle->getModel();

        return $dto;
    }
}