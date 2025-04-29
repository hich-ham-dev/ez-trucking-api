<?php

namespace Tests\Unit\Entity;

use App\Entity\Delivery;

test('waybill number peut être défini et récupéré', function () {
    $delivery = new Delivery();
    $delivery->setWaybillNumber('WB12345');
    expect($delivery->getWaybillNumber())->toBe('WB12345');
});

test('start date time peut être défini et récupéré', function () {
    $delivery = new Delivery();
    $startDateTime = new \DateTimeImmutable('2023-01-01 10:00:00');
    $delivery->setStartDateTime($startDateTime);
    expect($delivery->getStartDateTime())->toBe($startDateTime);
});

test('end date time peut être défini et récupéré', function () {
    $delivery = new Delivery();
    $endDateTime = new \DateTimeImmutable('2023-01-01 18:00:00');
    $delivery->setEndDateTime($endDateTime);
    expect($delivery->getEndDateTime())->toBe($endDateTime);
});

test('waybill number ne peut pas être null', function () {
    $delivery = new Delivery();
    expect(fn () => $delivery->setWaybillNumber(null))->toThrow(\TypeError::class);
});

test('start date time ne peut pas être null', function () {
    $delivery = new Delivery();
    expect(fn () => $delivery->setStartDateTime(null))->toThrow(\TypeError::class);
});

test('end date time ne peut pas être null', function () {
    $delivery = new Delivery();
    expect(fn () => $delivery->setEndDateTime(null))->toThrow(\TypeError::class);
});