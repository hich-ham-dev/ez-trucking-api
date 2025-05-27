<?php

namespace App\ApiResource\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\Delivery;
use App\Service\DeliveryService;

class DeliveryProvider implements ProviderInterface
{
    private DeliveryService $deliveryService;

    public function __construct(DeliveryService $deliveryService)
    {
        $this->deliveryService = $deliveryService;
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        // Pour une collection (GET /api/deliveries)
        if (!isset($uriVariables['id'])) {
            $filters = [];
            $orderBy = [];

            // Récupération des filtres à partir du contexte
            if (isset($context['filters'])) {
                if (isset($context['filters']['truck.id'])) {
                    $filters['truck'] = $context['filters']['truck.id'];
                }

                if (isset($context['filters']['trailer.id'])) {
                    $filters['trailer'] = $context['filters']['trailer.id'];
                }

                if (isset($context['filters']['status'])) {
                    $filters['status'] = $context['filters']['status'];
                }
            }

            // Pagination
            $page = $context['filters']['page'] ?? 1;
            $limit = $operation->getPaginationItemsPerPage() ?? 30;

            // Utilisation du service
            return $this->deliveryService->getDeliveries($filters, $orderBy, $page, $limit);
        }

        // Pour un item unique (GET /api/deliveries/{id})
        return $this->deliveryService->getDeliveryById($uriVariables['id']);
    }
}