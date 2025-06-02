<?php

namespace App\DataTransformer;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\Input\CreateDriverDto;
use App\Dto\Input\UpdateDriverDto;
use App\Entity\Driver;
use Doctrine\ORM\EntityManagerInterface;

final readonly class DriverInputTransformer implements ProcessorInterface
{
public function __construct(
private EntityManagerInterface $entityManager
) {}

public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Driver
{
if ($data instanceof CreateDriverDto) {
return $this->transformFromCreateDto($data);
}

if ($data instanceof UpdateDriverDto) {
return $this->transformFromUpdateDto($data, $uriVariables, $context);
}

throw new \InvalidArgumentException('Type d\'objet non supporté');
}

private function transformFromCreateDto(CreateDriverDto $dto): Driver
{
$driver = new Driver();
$driver->setFirstName(trim($dto->firstName));
$driver->setLastName(trim($dto->lastName));
$driver->setEmail(strtolower(trim($dto->email)));

if ($dto->phone) {
$driver->setPhone($this->formatPhoneNumber($dto->phone));
}

$driver->setLicenseNumber(strtoupper(trim($dto->licenseNumber)));
$driver->setBirthDate($dto->birthDate);
$driver->setIsActive($dto->isActive);
$driver->setNotes($dto->notes ? trim($dto->notes) : null);

// Persister et flush
$this->entityManager->persist($driver);
$this->entityManager->flush();

return $driver;
}

private function transformFromUpdateDto(UpdateDriverDto $dto, array $uriVariables, array $context): Driver
{
// Récupérer l'entité existante
$driverId = $uriVariables['id'] ?? throw new \LogicException('ID du driver manquant');
$driver = $this->entityManager->getRepository(Driver::class)->find($driverId);

if (!$driver) {
throw new \LogicException('Driver non trouvé');
}

if ($dto->firstName !== null) {
$driver->setFirstName(trim($dto->firstName));
}
if ($dto->lastName !== null) {
$driver->setLastName(trim($dto->lastName));
}
if ($dto->email !== null) {
$driver->setEmail(strtolower(trim($dto->email)));
}
if ($dto->phone !== null) {
$driver->setPhone($this->formatPhoneNumber($dto->phone));
}
if ($dto->licenseNumber !== null) {
$driver->setLicenseNumber(strtoupper(trim($dto->licenseNumber)));
}
if ($dto->birthDate !== null) {
$driver->setBirthDate($dto->birthDate);
}
if ($dto->isActive !== null) {
$driver->setIsActive($dto->isActive);
}
if ($dto->notes !== null) {
$driver->setNotes(trim($dto->notes) ?: null);
}

$this->entityManager->flush();
return $driver;
}

private function formatPhoneNumber(?string $phone): ?string
{
if (!$phone) return null;

// Supprime tous les espaces, tirets, points
$cleaned = preg_replace('/[\s\-\.]/', '', $phone);

// Convertit 0X en +33X
if (str_starts_with($cleaned, '0')) {
$cleaned = '+33' . substr($cleaned, 1);
}

return $cleaned;
}
}