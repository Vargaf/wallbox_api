<?php

namespace Wallbox\Tests\Users;

use Wallbox\Domain\Users\Model\User;
use Wallbox\Infrastructure\Users\AmazonUserRepository;

class AmazonUserRepositoryMock extends AmazonUserRepository {

    private $items = [];

    public function addUser(User $user): void {
        $this->items[] = $user;
    }

    public function clear(): void {
        $this->items = [];
    }

    protected function getUserList(): array {
        return $this->items;
    }

}