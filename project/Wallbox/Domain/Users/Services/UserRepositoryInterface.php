<?php

namespace Wallbox\Domain\Users\Services;

use WallBox\Domain\Users\Model\UserList;

interface UserRepositoryInterface {

    public function findAll(): UserList;

}