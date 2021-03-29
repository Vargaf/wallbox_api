<?php

namespace Wallbox\Infrastructure\Users;

use Wallbox\Domain\Users\Model\User;
use Wallbox\Domain\Users\Model\UserList;
use Wallbox\Domain\Users\Model\UserListFilterDTO;
use Wallbox\Domain\Users\Services\UserRepositoryInterface;

class AmazonUserRepository implements UserRepositoryInterface {

    public function findAll(UserListFilterDTO $userFilter = null): UserList
    {
        
        $userArray = $this->getUserList();
        
        if($this->hasToApplyActivationLenghtFilter($userFilter)) {
            $userArray = $this->filterByActivationLength($userFilter->activationLength, $userArray);
        }
        
        $orderedUserList = $this->orderByNameAndSurname($userArray);
        $userList = new UserList($orderedUserList);

        return $userList;
    }

    protected function getUserList(): array {
        $data = file_get_contents("https://wallbox.s3-eu-west-1.amazonaws.com/img/test/users.csv");
        $rows = explode("\n",$data);
        $userArray = [];
        foreach($rows as $row) {
            $csvRowItems = str_getcsv($row); 
            $userArray[] = new User(
                $csvRowItems[0],
                $csvRowItems[1],
                $csvRowItems[2],
                $csvRowItems[3],
                $csvRowItems[4],
                new \DateTime($csvRowItems[5]),
                new \DateTime($csvRowItems[6]),
                $csvRowItems[7]
            );
        }

        return $userArray;
    }

    private function orderByNameAndSurname(array $userList): array {
        $orderFunction = function($itemA, $itemB) {
            $comparsion = strcmp($itemA->name(), $itemB->name());

            if($comparsion === 0) {
                $comparsion = strcmp($itemA->surname(), $itemB->surname());
            }

            return $comparsion;
        };

        usort($userList, $orderFunction);

        return $userList;
    }

    private function hasToApplyActivationLenghtFilter(UserListFilterDTO $userFilter = null): bool {
        return $userFilter && $userFilter->activationLength !== null;
    }

    private function filterByActivationLength(int $activationLength, array $userList): array {

        $filteredUserList = [];
        foreach($userList as $user) {
            /** @var User $user */
            $actualActivationLength = $user->activateAt()->diff($user->createAt());
            $diff = intval($actualActivationLength->format('%a')); 
            if( $diff >= $activationLength ) {
                $filteredUserList[] = $user;
            }
        }

        return $filteredUserList;
    }

}