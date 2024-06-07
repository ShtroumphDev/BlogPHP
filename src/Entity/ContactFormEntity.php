<?php

namespace App\Entity;

use App\Entity\Abstracts\Entity;
use App\Repository\ContactFormRepository;
use DateTime;

class ContactFormEntity extends Entity
{
	private ?int $id                     = null;
	private ?string $email               = null;
	private ?string $firstName           = null;
	private ?string $lastName            = null;
	private ?string $message             = null;
	private null|string|DateTime $sendAt = null;

	public function getId(): ?int
	{
		return $this->id;
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

	public function getFirstName(): ?string
	{
		return $this->firstName;
	}

	public function setFirstName(string $firstName): self
	{
		$this->firstName = $firstName;

		return $this;
	}

	public function getLastName(): ?string
	{
		return $this->lastName;
	}

	public function setLastName(string $lastName): self
	{
		$this->lastName = $lastName;

		return $this;
	}

	public function getMessage(): ?string
	{
		return $this->message;
	}

	public function setMessage(string $message): self
	{
		$this->message = $message;

		return $this;
	}

	public function getSendAt(): ?DateTime
	{
		return $this->sendAt;
	}

	public function setSendAt(DateTime $sendAt): self
	{
		$this->sendAt = $sendAt;

		return $this;
	}

	protected function getEntityProperties(): array
	{
		return get_object_vars($this);
	}

	public function getDataBaseTableName(): string
	{
		return 'contactform';
	}

	public function getRepository(): ContactFormRepository
	{
		return new ContactFormRepository();
	}
}
