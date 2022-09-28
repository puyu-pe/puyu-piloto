<?php

namespace App\Saas\Product\Application\Edit;

class EditProductDto
{
    public function __construct(
        private readonly ?string $code = null,
        private readonly ?string $name = null,
        private readonly ?string $description = null,
        private readonly ?string $url = null,
        private readonly ?string $image = null,
    ) {
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }
}
