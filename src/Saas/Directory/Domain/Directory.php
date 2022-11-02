<?php

namespace App\Saas\Directory\Domain;

use App\Saas\Contact\Domain\Contact;
use App\Saas\Customer\Domain\Customer;
use App\Shared\Domain\Traits\SoftDeleteable;
use App\Shared\Domain\Traits\Timestampable;
use App\Shared\Domain\ValueObjects\Uuid;

class Directory
{
    use Timestampable;
    use SoftDeleteable;

    public function __construct(
        private readonly Uuid $id,
        private Customer $customer,
        private Contact $contact,
    ) {
    }

    public static function create(
        Customer $customer,
        Contact $contact,
    ): self {
        return new self(
            Uuid::v4(),
            $customer,
            $contact,
        );
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer): self
    {
        $this->customer = $customer;
        return $this;
    }

    public function getContact(): Contact
    {
        return $this->contact;
    }

    public function setContact(Contact $contact): self
    {
        $this->contact = $contact;
        return $this;
    }
}
