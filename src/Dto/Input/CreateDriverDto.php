<?php

namespace App\Dto\Input;

use Symfony\Component\Validator\Constraints as Assert;

class CreateDriverDto
{
    #[Assert\NotBlank(message: "Le prénom est obligatoire")]
    #[Assert\Length(min: 2, max: 255, minMessage: "Le prénom doit faire au moins 2 caractères")]
    public string $firstName;

    #[Assert\NotBlank(message: "Le nom est obligatoire")]
    #[Assert\Length(min: 2, max: 255, minMessage: "Le nom doit faire au moins 2 caractères")]
    public string $lastName;

    #[Assert\NotBlank(message: "L'email est obligatoire")]
    #[Assert\Email(message: "L'email '{{ value }}' n'est pas valide")]
    #[Assert\Length(max: 255)]
    public string $email;

    #[Assert\Regex(
        pattern: '/^(\+33|0)[1-9](\d{8})$/',
        message: "Le numéro de téléphone doit être au format français valide"
    )]
    public ?string $phone = null;

    #[Assert\NotBlank(message: "Le numéro de permis est obligatoire")]
    #[Assert\Length(max: 255)]
    public string $licenseNumber;

    #[Assert\LessThan(
        value: "today",
        message: "La date de naissance doit être antérieure à aujourd'hui"
    )]
    public ?\DateTimeImmutable $birthDate = null;

    public bool $isActive = true;

    #[Assert\Length(max: 1000, maxMessage: "Les notes ne peuvent pas dépasser 1000 caractères")]
    public ?string $notes = null;
}