<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Wallbox\Domain\Users\Application\UserListUseCase;

class UsersController {

    public function userList(Request $request, UserListUseCase $useCase) {
        
        $userList = $useCase->execute();

        $response = [];
        $response['items'] = $userList->toArray();
        
        return new JsonResponse($response);
    }

}