<?php

namespace App\ViewModel;

class DriverViewModel
{
public int $id;
public string $firstName;
public string $lastName;
public string $fullName;
public string $email;
public ?string $phone = null;
public string $licenseNumber;
public ?string $birthDate = null;
public bool $isActive;
public ?string $notes = null;
public string $createdAt;
public string $updatedAt;

// Propriétés calculées pour l'interface
public ?int $age = null;
public string $status;
public string $statusLabel;
public string $displayName;
public bool $isBirthdayToday = false;
public ?int $experienceYears = null;

// Statistiques (si nécessaire)
public int $totalDeliveries = 0;
public int $activeVehicleUsages = 0;
public bool $hasActiveDeliveries = false;

// Informations de contact formatées
public ?string $formattedPhone = null;
public ?string $phoneDisplay = null;

// Alertes et notifications
public array $alerts = [];
public bool $needsAttention = false;
}