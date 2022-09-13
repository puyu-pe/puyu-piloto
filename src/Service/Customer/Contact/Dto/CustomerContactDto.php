<?php

namespace App\Service\Customer\Contact\Dto;

use App\Entity\CustomerContact;
use Symfony\Component\HttpFoundation\Request;

class  CustomerContactDto
{
    public function __construct(
        private ?string $name = null,
        private ?string $lastName = null,
        private ?string $phone = null,
        private ?string $jobTitle = null,
    ) {
    }

    public static function create(): self
    {
        return new self();
    }

    public static function fromRequest(Request $request): self
    {
        $customerContactRequest = json_decode($request->getContent(), false, 512, JSON_THROW_ON_ERROR);

        return new self(
            $customerContactRequest->name ?? null,
            $customerContactRequest->lastName ?? null,
            $customerContactRequest->phone ?? null,
            $customerContactRequest->jobTitle ?? null,
        );
    }

    public function toCustomerContact(): CustomerContact
    {
        return CustomerContact::create(
            $this->name,
            $this->lastName,
            $this->phone,
            $this->jobTitle,
        );
    }



    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return CustomerContactDto
     */
    public function setName(?string $name): CustomerContactDto
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string|null $lastName
     * @return CustomerContactDto
     */
    public function setLastName(?string $lastName): CustomerContactDto
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     * @return CustomerContactDto
     */
    public function setPhone(?string $phone): CustomerContactDto
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getJobTitle(): ?string
    {
        return $this->jobTitle;
    }

    /**
     * @param string|null $jobTitle
     * @return CustomerContactDto
     */
    public function setJobTitle(?string $jobTitle): CustomerContactDto
    {
        $this->jobTitle = $jobTitle;
        return $this;
    }


}