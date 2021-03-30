<?php

namespace Wallbox\Domain\Users\Model;

use ArrayIterator;
use IteratorAggregate;

class UserList implements IteratorAggregate {

    private $items = [];

    public function __construct(array $userList) {
        $this->items = $userList;
    }

    public function getIterator() {
        return new ArrayIterator($this->items);
    }
}