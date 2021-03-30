<?php

namespace App\Controller\Users;

use Wallbox\Domain\Users\Model\User;
use Wallbox\Domain\Users\Model\UserList;

class UserListResponse
{
    public static function formatResponse(UserList $userList): array {
        $response = [];

        foreach($userList as $user) {
            /** @var User $user */
            $item = [];
            $item['id'] = $user->id();
            $item['name'] = $user->name();
            $item['surname'] = $user->surname();
            $item['email'] = $user->email();
            $item['country'] = $user->country();
            $item['createAt'] = $user->createAt()->format('Ymd');
            $item['activateAt'] = $user->activateAt()->format('Ymd');
            $item['chargerId'] = $user->chargerId();

            $response[] = $item;
        }

        return $response;
    }
}
