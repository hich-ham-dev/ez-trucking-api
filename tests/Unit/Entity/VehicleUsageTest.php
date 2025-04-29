<?php

use App\Entity\VehicleUsage;

test('start date time can be set and retrieved', function () {
    $vehicleUsage = new VehicleUsage();
    $startDateTime = new \DateTimeImmutable('2023-01-01 10:00:00');
    $vehicleUsage->setStartDateTime($startDateTime);
    expect($vehicleUsage->getStartDateTime())->toBe($startDateTime);
});

test('end date time can be set and retrieved', function () {
    $vehicleUsage = new VehicleUsage();
    $endDateTime = new \DateTimeImmutable('2023-01-01 18:00:00');
    $vehicleUsage->setEndDateTime($endDateTime);
    expect($vehicleUsage->getEndDateTime())->toBe($endDateTime);
});

test('start date time cannot be null', function () {
    $vehicleUsage = new VehicleUsage();
    expect(fn () => $vehicleUsage->setStartDateTime(null))->toThrow(\TypeError::class);
});

test('end date time cannot be null', function () {
    $vehicleUsage = new VehicleUsage();
    expect(fn () => $vehicleUsage->setEndDateTime(null))->toThrow(\TypeError::class);
});