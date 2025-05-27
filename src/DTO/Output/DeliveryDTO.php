<?php

namespace App\DTO\Output;

use Symfony\Component\Serializer\Annotation\Groups;

class DeliveryDTO
{
    #[Groups(['delivery:read'])]
    public int $id;

    #[Groups(['delivery:read'])]
    public string $trackingNumber;

    #[Groups(['delivery:read', 'delivery:details'])]
    public string $deliveryAddress;

    #[Groups(['delivery:read', 'delivery:details'])]
    public ?string $recipientName;

    #[Groups(['delivery:read', 'delivery:details'])]
    public ?string $recipientPhone;

    #[Groups(['delivery:read', 'delivery:details'])]
    public string $scheduledAt;

    #[Groups(['delivery:read', 'delivery:details'])]
    public ?string $completedAt;

    #[Groups(['delivery:read'])]
    public string $status;

    #[Groups(['delivery:read', 'delivery:details'])]
    public ?float $weight;

    #[Groups(['delivery:read', 'delivery:details'])]
    public DriverDTO $driver;

    #[Groups(['delivery:read', 'delivery:details'])]
    public VehicleDTO $truck;

    #[Groups(['delivery:read', 'delivery:details'])]
    public ?VehicleDTO $trailer;

    #[Groups(['delivery:details'])]
    public ?string $notes;

    #[Groups(['delivery:details'])]
    public ?float $latitude;

    #[Groups(['delivery:details'])]
    public ?float $longitude;

    public static function fromEntity(\App\Entity\Delivery $delivery): self
    {
        $dto = new self();
        $dto->id = $delivery->getId();
        $dto->trackingNumber = $delivery->getTrackingNumber();
        $dto->deliveryAddress = $delivery->getDeliveryAddress();
        $dto->recipientName = $delivery->getRecipientName();
        $dto->recipientPhone = $delivery->getRecipientPhone();
        $dto->scheduledAt = $delivery->getScheduledAt()->format('Y-m-d\TH:i:s\Z');
        $dto->completedAt = $delivery->getCompletedAt()?->format('Y-m-d\TH:i:s\Z');
        $dto->status = $delivery->getStatus();
        $dto->weight = $delivery->getWeight();
        $dto->notes = $delivery->getNotes();
        $dto->latitude = $delivery->getLatitude();
        $dto->longitude = $delivery->getLongitude();

        // Conversion des relations en DTOs
        $dto->driver = DriverDTO::fromEntity($delivery->getDriver());
        $dto->truck = VehicleDTO::fromEntity($delivery->getTruck());
        $dto->trailer = $delivery->getTrailer() ? VehicleDTO::fromEntity($delivery->getTrailer()) : null;

        return $dto;
    }
}