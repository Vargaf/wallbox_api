<?php

namespace Wallbox\Domain\Users\Model;

class User {

    public function __construct(
        private int $id,
        private string $name,
        private string $surname,
        private string $email,
        private string $country,
        private \DateTime $createAt,
        private \DateTime $activateAt,
        private int $chargerId)
    {}

    public function id(): int {
        return $this->id;
    }

    public function name(): string {
        return $this->name;
    }

    public function surname(): string {
        return $this->surname;
    }

    public function email(): string {
        return $this->email;
    }

    public function country(): string {
        return $this->country;
    }

    public function createAt(): \DateTime {
        return $this->createAt;
    }

    public function activateAt(): \DateTime {
        return $this->activateAt;
    }

    public function chargerId(): int {
        return $this->chargerId;
    }

}