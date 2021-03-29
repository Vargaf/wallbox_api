<?php

namespace Wallbox\Infrastructure\Users;

use Wallbox\Domain\Users\Model\User;
use Wallbox\Domain\Users\Model\UserList;
use Wallbox\Domain\Users\Service\UserRepositoryInterface;

class AmazonUserRepository implements UserRepositoryInterface {

    public function findAll(): UserList
    {
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

        $orderedUserList = $this->orderByNameAndSurname($userArray);
        $userList = new UserList($orderedUserList);

        return $userList;
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

}