<?php

namespace Wallbox\Domain\Users\Service;

use WallBox\Domain\Users\Model\UserList;

interface UserRepositoryInterface {

    public function findAll(): UserList;

}