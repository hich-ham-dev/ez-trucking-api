<?php

namespace App\ViewModel;

use App\Entity\Delivery;

class DeliveryViewModel
{
    public int $id;
    public string $trackingNumber;
    public string $deliveryAddress;
    public string $formattedScheduledDate;
    public ?string $formattedCompletedDate;
    public string $statusLabel;
    public string $statusClass;
    public ?string $weightDisplay;
    public string $driverName;
    public string $truckInfo;
    public ?string $trailerInfo;

    public static function fromEntity(Delivery $delivery): self
    {
        $viewModel = new self();
        $viewModel->id = $delivery->getId();
        $viewModel->trackingNumber = $delivery->getTrackingNumber();
        $viewModel->deliveryAddress = $delivery->getDeliveryAddress();

        // Formatage des dates pour l'affichage
        $viewModel->formattedScheduledDate = $delivery->getScheduledAt()->format('d/m/Y H:i');
        $viewModel->formattedCompletedDate = $delivery->getCompletedAt()?->format('d/m/Y H:i');

        // Formatage du statut avec label et classe CSS
        $viewModel->statusLabel = self::getStatusLabel($delivery->getStatus());
        $viewModel->statusClass = self::getStatusClass($delivery->getStatus());

        // Formatage du poids
        $viewModel->weightDisplay = $delivery->getWeight()
            ? $delivery->getWeight() . ' tonnes'
            : null;

        // Informations sur le conducteur et les véhicules
        $viewModel->driverName = $delivery->getDriver()->getFullName(); // Adapter selon votre entité Driver
        $viewModel->truckInfo = $delivery->getTruck()->getModel() . ' (' . $delivery->getTruck()->getLicensePlate() . ')';
        $viewModel->trailerInfo = $delivery->getTrailer()
            ? $delivery->getTrailer()->getModel() . ' (' . $delivery->getTrailer()->getLicensePlate() . ')'
            : null;

        return $viewModel;
    }

    private static function getStatusLabel(string $status): string
    {
        return match($status) {
            'planifiée' => 'Planifiée',
            'en cours' => 'En cours de livraison',
            'livrée' => 'Livraison terminée',
            'annulée' => 'Annulée',
            'reportée' => 'Reportée',
            default => $status
        };
    }

    private static function getStatusClass(string $status): string
    {
        return match($status) {
            'planifiée' => 'bg-blue-100 text-blue-800',
            'en cours' => 'bg-orange-100 text-orange-800',
            'livrée' => 'bg-green-100 text-green-800',
            'annulée' => 'bg-red-100 text-red-800',
            'reportée' => 'bg-purple-100 text-purple-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }
}