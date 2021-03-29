<?php

namespace Wallbox\Domain\Users\Application;

use WallBox\Domain\Users\Model\UserList;
use Wallbox\Domain\Users\Service\UserRepositoryInterface;

class UserListUseCase {

    public function __construct(
        private UserRepositoryInterface $userRepository
    )
    {}

    public function execute(): UserList {
        return $this->userRepository->findAll();
    }

}