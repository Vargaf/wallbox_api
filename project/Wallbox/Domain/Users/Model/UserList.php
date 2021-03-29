<?php

namespace Wallbox\Domain\Users\Model;

use ArrayIterator;
use IteratorAggregate;
use Wallbox\Domain\Users\Model\User;

class UserList implements IteratorAggregate {

    private $items = [];

    public function __construct(array $userList) {
        $this->items = $userList;
    }

    public function getIterator() {
        return new ArrayIterator($this->items);
    }

    public function toArray(): array {
        $itemsArray = [];

        foreach($this->items as $user) {
            /** @var User $user */
            $item = [];
            $item['id'] = $user->id();
            $item['name'] = $user->name();
            $item['surname'] = $user->surname();
            $item['email'] = $user->email();
            $item['country'] = $user->country();
            $item['createAt'] = $user->createAt()->getTimestamp();
            $item['activateAt'] = $user->activateAt()->getTimestamp();
            $item['chargerId'] = $user->chargerId();
            $itemsArray[] = $item;
        }

        return $itemsArray;
    }

}