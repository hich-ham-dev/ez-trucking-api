<?php

namespace App\Service;

use App\Dto\Input\CreateDeliveryDto;
use App\Entity\Delivery;
use App\Repository\DeliveryRepository;
use App\Repository\DriverRepository;
use App\Repository\VehicleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DeliveryService
{
    private DeliveryRepository $deliveryRepository;
    private DriverRepository $driverRepository;
    private VehicleRepository $vehicleRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(
        DeliveryRepository $deliveryRepository,
        DriverRepository $driverRepository,
        VehicleRepository $vehicleRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->deliveryRepository = $deliveryRepository;
        $this->driverRepository = $driverRepository;
        $this->vehicleRepository = $vehicleRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * Crée une nouvelle livraison à partir d'un Dto
     */
    public function createDelivery(CreateDeliveryDto $dto): CreateDeliveryDto
    {
        // Récupération des entités liées
        $driver = $this->driverRepository->find($dto->driverId);
        if (!$driver) {
            throw new NotFoundHttpException('Conducteur non trouvé');
        }

        $truck = $this->vehicleRepository->find($dto->truckId);
        if (!$truck) {
            throw new NotFoundHttpException('Véhicule tracteur non trouvé');
        }

        $trailer = null;
        if ($dto->trailerId) {
            $trailer = $this->vehicleRepository->find($dto->trailerId);
            if (!$trailer) {
                throw new NotFoundHttpException('Remorque non trouvée');
            }
        }

        // Création de l'entité
        $delivery = new Delivery();
        $delivery->setTrackingNumber($dto->trackingNumber);
        $delivery->setDeliveryAddress($dto->deliveryAddress);
        $delivery->setRecipientName($dto->recipientName);
        $delivery->setRecipientPhone($dto->recipientPhone);
        $delivery->setScheduledAt($dto->scheduledAt);
        $delivery->setStatus('planifiée');
        $delivery->setWeight($dto->weight);
        $delivery->setDriver($driver);
        $delivery->setTruck($truck);
        $delivery->setTrailer($trailer);
        $delivery->setNotes($dto->notes);
        $delivery->setLatitude($dto->latitude);
        $delivery->setLongitude($dto->longitude);

        // Persistance
        $this->entityManager->persist($delivery);
        $this->entityManager->flush();

        // Conversion en Dto de sortie
        return DeliveryDTO::fromEntity($delivery);
    }

    /**
     * Récupère une livraison par son ID
     */
    public function getDeliveryById(int $id): DeliveryDto
    {
        $delivery = $this->deliveryRepository->find($id);
        if (!$delivery) {
            throw new NotFoundHttpException('Livraison non trouvée');
        }

        return DeliveryDto::fromEntity($delivery);
    }

    /**
     * Liste les livraisons avec filtres
     */
    public function getDeliveries(array $filters = [], array $orderBy = [], int $page = 1, int $limit = 20): array
    {
        $qb = $this->deliveryRepository->createQueryBuilder('d');

        // Appliquer les filtres
        if (isset($filters['truck'])) {
            $qb->andWhere('d.truck = :truck')
                ->setParameter('truck', $filters['truck']);
        }

        if (isset($filters['trailer'])) {
            $qb->andWhere('d.trailer = :trailer')
                ->setParameter('trailer', $filters['trailer']);
        }

        if (isset($filters['status'])) {
            $qb->andWhere('d.status = :status')
                ->setParameter('status', $filters['status']);
        }

        // Appliquer le tri
        foreach ($orderBy as $field => $direction) {
            $qb->addOrderBy('d.' . $field, $direction);
        }

        // Pagination
        $qb->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit);

        $deliveries = $qb->getQuery()->getResult();

        // Conversion en DTOs
        return array_map(function (Delivery $delivery) {
            return DeliveryDTO::fromEntity($delivery);
        }, $deliveries);
    }

    /**
     * Met à jour le statut d'une livraison
     */
    public function updateDeliveryStatus(int $id, string $status): DeliveryDTO
    {
        $delivery = $this->deliveryRepository->find($id);
        if (!$delivery) {
            throw new NotFoundHttpException('Livraison non trouvée');
        }

        // Logique métier pour valider les transitions d'état
        if ($status === 'livrée' && $delivery->getStatus() !== 'en cours') {
            throw new \InvalidArgumentException('Seule une livraison en cours peut être marquée comme livrée');
        }

        // Mise à jour du statut
        $delivery->setStatus($status);

        // Si la livraison est terminée, on enregistre la date
        if ($status === 'livrée') {
            $delivery->setCompletedAt(new \DateTimeImmutable());
        }

        $this->entityManager->flush();

        return DeliveryDTO::fromEntity($delivery);
    }

}