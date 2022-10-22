<?php

namespace App\Saas\Customer\Domain\Entity;

use App\Saas\Project\Domain\Entity\Project;
use App\Shared\Domain\ValueObjects\Uuid;

class Customer
{
    /**
     * @var Project[]|null $projects
     */
    private ?array $projects;

    public function __construct(
        private readonly Uuid $id,
        private string $documentNumber,
        private string $name,
        private string $address,
        private string $email,
        private string $phone
    ) {
        $this->projects = [];
    }

    public static function create(
        string $documentNumber,
        string $name,
        string $address,
        string $email,
        string $phone,
    ): self {
        return new self(
            Uuid::v4(),
            $documentNumber,
            $name,
            $address,
            $email,
            $phone
        );
    }


    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getDocumentNumber(): ?string
    {
        return $this->documentNumber;
    }

    public function setDocumentNumber(string $documentNumber): self
    {
        $this->documentNumber = $documentNumber;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return Project[]|null
     */
    public function getProjects(): ?array
    {
        return $this->projects;
    }

}
