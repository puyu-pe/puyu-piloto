<?php

namespace App\Saas\Product\Domain\Entity;

use Symfony\Component\Uid\Uuid;

class Product
{

    public function __construct(
        private readonly Uuid $id,
        private string $code,
        private string $name,
        private ?string $descripcion,
        private string $url,
        private ?string $image,
    ) {
    }

    public function create(
        string $code,
        string $name,
        string $descripcion,
        string $url,
        string $image
    ): self {
        return new self(
            Uuid::v4(),
            $code,
            $name,
            $descripcion,
            $url,
            $image
        );
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(): string
    {
        return $this->code;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }
}
