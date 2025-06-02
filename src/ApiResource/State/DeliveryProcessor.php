<?php

namespace App\ApiResource\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\DTO\Input\CreateDeliveryDto;
use App\Service\DeliveryService;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class DeliveryProcessor implements ProcessorInterface
{
    private DeliveryService $deliveryService;
    private SerializerInterface $serializer;

    public function __construct(DeliveryService $deliveryService, SerializerInterface $serializer)
    {
        $this->deliveryService = $deliveryService;
        $this->serializer = $serializer;
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        // Pour la création (POST /api/deliveries)
        if ($operation->getName() === 'post') {
            // Conversion en Dto si nécessaire
            if (!$data instanceof CreateDeliveryDto) {
                $dto = new CreateDeliveryDto();
                $this->serializer->deserialize(
                    $this->serializer->serialize($data, 'json'),
                    CreateDeliveryDto::class,
                    'json',
                    [AbstractNormalizer::OBJECT_TO_POPULATE => $dto]
                );
                $data = $dto;
            }

            return $this->deliveryService->createDelivery($data);
        }

        // Pour la mise à jour du statut (PATCH /api/deliveries/{id})
        if ($operation->getName() === 'patch' && isset($uriVariables['id'])) {
            if (isset($data->status)) {
                return $this->deliveryService->updateDeliveryStatus($uriVariables['id'], $data->status);
            }
        }

        return $data;
    }
}