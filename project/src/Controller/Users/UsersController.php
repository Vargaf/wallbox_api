<?php

namespace App\Controller\Users;

use App\Controller\Users\UserListResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Wallbox\Domain\Users\Application\UserListUseCase;
use Wallbox\Domain\Users\Model\UserListFilterDTO;

class UsersController {

    public function userList(Request $request, UserListUseCase $useCase) {

        $userListFilter = new UserListFilterDTO();

        if($request->getContent()) {
            $requestContent = $request->toArray();

            try {
                if(key_exists('activation_length', $requestContent)) {
                    $userListFilter->activationLength = $requestContent['activation_length'];
                }
        
                if(key_exists('countries', $requestContent)) {
                    $userListFilter->countries = $requestContent['countries'];
                }
            } catch(\TypeError $e) {
                return new JsonResponse('Bad request', JsonResponse::HTTP_BAD_REQUEST);
            }
        }

        $userList = $useCase->execute($userListFilter);

        $userListResponse = UserListResponse::formatResponse($userList);
        $response['items'] = $userListResponse;
        
        return new JsonResponse($response);
    }

}