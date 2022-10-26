<?php

namespace App\Saas\Product\Domain\Entity;

use App\Saas\Project\Domain\Entity\Project;
use App\Shared\Domain\ValueObjects\Uuid;

class Product
{
    /**
     * @var Project[]|null $projects
     */
    private mixed $projects;

    public function __construct(
        private readonly Uuid $id,
        private string $code,
        private string $name,
        private ?string $description,
        private string $url,
        private ?string $image
    ) {
        $this->projects = [];
    }

    public static function create(
        string $code,
        string $name,
        string $description,
        string $url,
        string $image
    ): self {
        return new self(
            Uuid::v4(),
            $code,
            $name,
            $description,
            $url,
            $image
        );
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(
        string $code
    ): self {
        $this->code = $code;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(
        string $name
    ): self {
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

    /**
     * @return Project[]|null
     */
    public function getProjects(): mixed
    {
        return $this->projects;
    }

}
