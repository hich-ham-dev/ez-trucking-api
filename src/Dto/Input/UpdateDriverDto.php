<?php

namespace App\Dto\Input;

use Symfony\Component\Validator\Constraints as Assert;

class UpdateDriverDto
{
    #[Assert\Length(min: 2, max: 255, minMessage: "Le prénom doit faire au moins 2 caractères")]
    public ?string $firstName = null;

    #[Assert\Length(min: 2, max: 255, minMessage: "Le nom doit faire au moins 2 caractères")]
    public ?string $lastName = null;

    #[Assert\Email(message: "L'email '{{ value }}' n'est pas valide")]
    #[Assert\Length(max: 255)]
    public ?string $email = null;

    #[Assert\Regex(
        pattern: '/^(\+33|0)[1-9](\d{8})$/',
        message: "Le numéro de téléphone doit être au format français valide"
    )]
    public ?string $phone = null;

    #[Assert\Length(max: 255)]
    public ?string $licenseNumber = null;

    #[Assert\LessThan(
        value: "today",
        message: "La date de naissance doit être antérieure à aujourd'hui"
    )]
    public ?\DateTimeImmutable $birthDate = null;

    public ?bool $isActive = null;

    #[Assert\Length(max: 1000, maxMessage: "Les notes ne peuvent pas dépasser 1000 caractères")]
    public ?string $notes = null;
}