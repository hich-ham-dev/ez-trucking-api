<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Entity\Driver;
use App\ViewModel\DriverViewModel;
use Symfony\Component\Serializer\Attribute\AsDataTransformer;

#[AsDataTransformer]
class DriverOutputTransformer implements DataTransformerInterface
{
public function transform($object, string $to, array $context = []): DriverViewModel
{
if (!$object instanceof Driver) {
throw new \InvalidArgumentException('Driver entity attendue');
}

$viewModel = new DriverViewModel();

// Données de base
$viewModel->id = $object->getId();
$viewModel->firstName = $object->getFirstName();
$viewModel->lastName = $object->getLastName();
$viewModel->fullName = $object->getFullName();
$viewModel->email = $object->getEmail();
$viewModel->phone = $object->getPhone();
$viewModel->licenseNumber = $object->getLicenseNumber();
$viewModel->birthDate = $object->getBirthDate()?->format('Y-m-d');
$viewModel->isActive = $object->isIsActive();
$viewModel->notes = $object->getNotes();
$viewModel->createdAt = $object->getCreatedAt()->format('c');
$viewModel->updatedAt = $object->getUpdatedAt()->format('c');

// Propriétés calculées
$viewModel->age = $this->calculateAge($object->getBirthDate());
$viewModel->status = $this->determineStatus($object);
$viewModel->statusLabel = $this->getStatusLabel($viewModel->status);
$viewModel->displayName = $this->getDisplayName($object);
$viewModel->isBirthdayToday = $this->isBirthdayToday($object->getBirthDate());
$viewModel->experienceYears = $this->calculateExperienceYears($object);

// Statistiques
$viewModel->totalDeliveries = $object->getDeliveries()->count();
$viewModel->activeVehicleUsages = $this->countActiveVehicleUsages($object);
$viewModel->hasActiveDeliveries = $this->hasActiveDeliveries($object);

// Formatage du téléphone
$viewModel->formattedPhone = $this->formatPhoneForDisplay($object->getPhone());
$viewModel->phoneDisplay = $viewModel->formattedPhone;

// Alertes
$viewModel->alerts = $this->generateAlerts($object);
$viewModel->needsAttention = !empty($viewModel->alerts);

return $viewModel;
}

private function calculateAge(?\DateTimeImmutable $birthDate): ?int
{
if (!$birthDate) return null;

return $birthDate->diff(new \DateTimeImmutable())->y;
}

private function determineStatus(Driver $driver): string
{
if (!$driver->isIsActive()) {
return 'off_duty';
}

// Logique pour déterminer si le chauffeur est en conduite
if ($this->hasActiveDeliveries($driver)) {
return 'driving';
}

return 'available';
}

private function getStatusLabel(string $status): string
{
return match ($status) {
'available' => 'Disponible',
'driving' => 'En conduite',
'off_duty' => 'Repos',
default => 'Statut inconnu'
};
}

private function getDisplayName(Driver $driver): string
{
return sprintf('%s %s.', $driver->getFirstName(), strtoupper($driver->getLastName()[0]));
}

private function isBirthdayToday(?\DateTimeImmutable $birthDate): bool
{
if (!$birthDate) return false;

$today = new \DateTimeImmutable();
return $birthDate->format('m-d') === $today->format('m-d');
}

private function calculateExperienceYears(Driver $driver): ?int
{
// Supposons que l'expérience soit calculée depuis la création du compte
// Vous pourriez avoir un champ dédié pour la date d'obtention du permis
return $driver->getCreatedAt()->diff(new \DateTimeImmutable())->y;
}

private function countActiveVehicleUsages(Driver $driver): int
{
$active = 0;
foreach ($driver->getVehicleUsages() as $usage) {
// Supposons qu'il y ait une méthode isActive() sur VehicleUsage
// if ($usage->isActive()) {
//     $active++;
// }
}
return $active;
}

private function hasActiveDeliveries(Driver $driver): bool
{
foreach ($driver->getDeliveries() as $delivery) {
// Supposons qu'il y ait une méthode pour vérifier le statut de livraison
// if ($delivery->isInProgress()) {
//     return true;
// }
}
return false;
}

private function formatPhoneForDisplay(?string $phone): ?string
{
if (!$phone) return null;

if (str_starts_with($phone, '+33')) {
// Format: +33 X XX XX XX XX
$number = substr($phone, 3);
return '+33 ' . chunk_split($number, 1, ' ');
}

return $phone;
}

private function generateAlerts(Driver $driver): array
{
$alerts = [];

if (!$driver->isIsActive()) {
$alerts[] = [
'type' => 'warning',
'message' => 'Chauffeur inactif'
];
}

if ($this->isBirthdayToday($driver->getBirthDate())) {
$alerts[] = [
'type' => 'info',
'message' => 'Anniversaire aujourd\'hui ! 🎉'
];
}

$age = $this->calculateAge($driver->getBirthDate());
if ($age && $age >= 65) {
$alerts[] = [
'type' => 'info',
'message' => 'Chauffeur senior - vérifier les conditions médicales'
];
}

return $alerts;
}

public function supportsTransformation($data, string $to, array $context = []): bool
{
return $data instanceof Driver && $to === DriverViewModel::class;
}
}