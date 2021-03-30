<?php

namespace Wallbox\Domain\Users\Application;

use WallBox\Domain\Users\Model\UserList;
use Wallbox\Domain\Users\Model\UserListFilterDTO;
use Wallbox\Domain\Users\Services\UserRepositoryInterface;

class UserListUseCase {

    public function __construct(
        private UserRepositoryInterface $userRepository
    )
    {}

    public function execute(UserListFilterDTO $userListFilter = null): UserList {
        return $this->userRepository->find($userListFilter);
    }

}