<?php

namespace Wallbox\Domain\Users\Services;

use WallBox\Domain\Users\Model\UserList;
use Wallbox\Domain\Users\Model\UserListFilterDTO;

interface UserRepositoryInterface {

    public function findAll(UserListFilterDTO $userFilter = null): UserList;

}