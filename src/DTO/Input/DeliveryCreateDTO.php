<?php

namespace App\DTO\Input;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

class DeliveryCreateDTO
{
    #[Assert\NotBlank(message: "Le numéro de suivi est obligatoire")]
    #[Groups(['delivery:write'])]
    public string $trackingNumber;

    #[Assert\NotBlank(message: "L'adresse de livraison est obligatoire")]
    #[Groups(['delivery:write'])]
    public string $deliveryAddress;

    #[Groups(['delivery:write'])]
    public ?string $recipientName = null;

    #[Groups(['delivery:write'])]
    public ?string $recipientPhone = null;

    #[Assert\NotNull(message: "La date de livraison planifiée est obligatoire")]
    #[Groups(['delivery:write'])]
    public \DateTimeImmutable $scheduledAt;

    #[Groups(['delivery:write'])]
    public ?float $weight = null;

    #[Assert\NotNull(message: "Le conducteur est obligatoire")]
    #[Groups(['delivery:write'])]
    public int $driverId;

    #[Assert\NotNull(message: "Le véhicule tracteur est obligatoire")]
    #[Groups(['delivery:write'])]
    public int $truckId;

    #[Groups(['delivery:write'])]
    public ?int $trailerId = null;

    #[Groups(['delivery:write'])]
    public ?string $notes = null;

    #[Groups(['delivery:write'])]
    public ?float $latitude = null;

    #[Groups(['delivery:write'])]
    public ?float $longitude = null;
}