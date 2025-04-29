<?php

use App\Entity\Driver;

test('last name can be set and retrieved', function () {
$driver = new Driver();
$driver->setLastName('Doe');
expect($driver->getLastName())->toBe('Doe');
});

test('first name can be set and retrieved', function () {
$driver = new Driver();
$driver->setFirstName('John');
expect($driver->getFirstName())->toBe('John');
});

test('license number can be set and retrieved', function () {
$driver = new Driver();
$driver->setLicenseNumber('LIC12345');
expect($driver->getLicenseNumber())->toBe('LIC12345');
});

test('hire date can be set and retrieved', function () {
$driver = new Driver();
$hireDate = new \DateTimeImmutable('2023-01-01');
$driver->setHireDate($hireDate);
expect($driver->getHireDate())->toBe($hireDate);
});

test('FCO certification date can be set and retrieved', function () {
$driver = new Driver();
$fcoDate = new \DateTimeImmutable('2023-02-01');
$driver->setFcoCertificationDate($fcoDate);
expect($driver->getFcoCertificationDate())->toBe($fcoDate);
});

test('phone number can be set and retrieved', function () {
$driver = new Driver();
$driver->setPhoneNumber('1234567890');
expect($driver->getPhoneNumber())->toBe('1234567890');
});

test('email can be set and retrieved', function () {
$driver = new Driver();
$driver->setEmail('john.doe@example.com');
expect($driver->getEmail())->toBe('john.doe@example.com');
});

test('ADR certification date can be set and retrieved', function () {
$driver = new Driver();
$adrDate = new \DateTimeImmutable('2023-03-01');
$driver->setAdrCertificationDate($adrDate);
expect($driver->getAdrCertificationDate())->toBe($adrDate);
});

test('license expiration date can be set and retrieved', function () {
$driver = new Driver();
$expirationDate = new \DateTimeImmutable('2024-01-01');
$driver->setLicenseExpirationDate($expirationDate);
expect($driver->getLicenseExpirationDate())->toBe($expirationDate);
});

test('last name cannot be null', function () {
$driver = new Driver();
expect(fn () => $driver->setLastName(null))->toThrow(\TypeError::class);
});

test('first name cannot be null', function () {
$driver = new Driver();
expect(fn () => $driver->setFirstName(null))->toThrow(\TypeError::class);
});

test('license number cannot be null', function () {
$driver = new Driver();
expect(fn () => $driver->setLicenseNumber(null))->toThrow(\TypeError::class);
});

test('hire date cannot be null', function () {
$driver = new Driver();
expect(fn () => $driver->setHireDate(null))->toThrow(\TypeError::class);
});

test('FCO certification date cannot be null', function () {
$driver = new Driver();
expect(fn () => $driver->setFcoCertificationDate(null))->toThrow(\TypeError::class);
});

test('phone number cannot be null', function () {
$driver = new Driver();
expect(fn () => $driver->setPhoneNumber(null))->toThrow(\TypeError::class);
});

test('email cannot be null', function () {
$driver = new Driver();
expect(fn () => $driver->setEmail(null))->toThrow(\TypeError::class);
});

test('ADR certification date cannot be null', function () {
$driver = new Driver();
expect(fn () => $driver->setAdrCertificationDate(null))->toThrow(\TypeError::class);
});

test('license expiration date cannot be null', function () {
$driver = new Driver();
expect(fn () => $driver->setLicenseExpirationDate(null))->toThrow(\TypeError::class);
});