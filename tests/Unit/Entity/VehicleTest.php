<?php

use App\Entity\Vehicle;

test('brand can be set and retrieved', function () {
$vehicle = new Vehicle();
$vehicle->setBrand('Toyota');
expect($vehicle->getBrand())->toBe('Toyota');
});

test('registration can be set and retrieved', function () {
$vehicle = new Vehicle();
$vehicle->setRegistration('ABC123');
expect($vehicle->getRegistration())->toBe('ABC123');
});

test('date of entry can be set and retrieved', function () {
$vehicle = new Vehicle();
$dateOfEntry = new \DateTimeImmutable('2023-01-01');
$vehicle->setDateOfEntry($dateOfEntry);
expect($vehicle->getDateOfEntry())->toBe($dateOfEntry);
});

test('purchase date can be set and retrieved', function () {
$vehicle = new Vehicle();
$purchaseDate = new \DateTimeImmutable('2023-02-01');
$vehicle->setPurchaseDate($purchaseDate);
expect($vehicle->getPurchaseDate())->toBe($purchaseDate);
});

test('technical inspection date can be set and retrieved', function () {
$vehicle = new Vehicle();
$inspectionDate = new \DateTimeImmutable('2023-03-01');
$vehicle->setTechnicalInspectionDate($inspectionDate);
expect($vehicle->getTechnicalInspectionDate())->toBe($inspectionDate);
});

test('speed limiter check date can be set and retrieved', function () {
$vehicle = new Vehicle();
$limiterDate = new \DateTimeImmutable('2023-04-01');
$vehicle->setSpeedLimiterCheckDate($limiterDate);
expect($vehicle->getSpeedLimiterCheckDate())->toBe($limiterDate);
});

test('tachograph check date can be set and retrieved', function () {
$vehicle = new Vehicle();
$tachographDate = new \DateTimeImmutable('2023-05-01');
$vehicle->setTachographCheckDate($tachographDate);
expect($vehicle->getTachographCheckDate())->toBe($tachographDate);
});

test('vehicle type can be set and retrieved', function () {
$vehicle = new Vehicle();
$vehicle->setVahicleType('Truck');
expect($vehicle->getVahicleType())->toBe('Truck');
});

test('brand cannot be null', function () {
$vehicle = new Vehicle();
expect(fn () => $vehicle->setBrand(null))->toThrow(\TypeError::class);
});

test('registration cannot be null', function () {
$vehicle = new Vehicle();
expect(fn () => $vehicle->setRegistration(null))->toThrow(\TypeError::class);
});

test('date of entry cannot be null', function () {
$vehicle = new Vehicle();
expect(fn () => $vehicle->setDateOfEntry(null))->toThrow(\TypeError::class);
});

test('purchase date cannot be null', function () {
$vehicle = new Vehicle();
expect(fn () => $vehicle->setPurchaseDate(null))->toThrow(\TypeError::class);
});

test('technical inspection date cannot be null', function () {
$vehicle = new Vehicle();
expect(fn () => $vehicle->setTechnicalInspectionDate(null))->toThrow(\TypeError::class);
});

test('speed limiter check date cannot be null', function () {
$vehicle = new Vehicle();
expect(fn () => $vehicle->setSpeedLimiterCheckDate(null))->toThrow(\TypeError::class);
});

test('tachograph check date cannot be null', function () {
$vehicle = new Vehicle();
expect(fn () => $vehicle->setTachographCheckDate(null))->toThrow(\TypeError::class);
});

test('vehicle type cannot be null', function () {
$vehicle = new Vehicle();
expect(fn () => $vehicle->setVahicleType(null))->toThrow(\TypeError::class);
});