<?php

namespace Wallbox\Tests\Users;

use PHPUnit\Framework\TestCase;
use Wallbox\Domain\Users\Model\User;
use Wallbox\Domain\Users\Model\UserListFilterDTO;

class AmazonUserRepositoryTest extends TestCase {

    private AmazonUserRepositoryMock $userRepository;

    protected function setUp(): void {
        $this->userRepository = new AmazonUserRepositoryMock();
    }

    protected function tearDown(): void {
        $this->userRepository->clear();
    }

    public function testOrderElements() {

        $rawUserList = $this->orderElementsRepositoryProvider();
        $this->populateUserRepository($rawUserList);

        $userList = $this->userRepository->find();
        $userItems = $userList->getIterator();

        $this->assertUser($rawUserList[3], $userItems[0]);
        $this->assertUser($rawUserList[2], $userItems[1]);
        $this->assertUser($rawUserList[1], $userItems[2]);
        $this->assertUser($rawUserList[0], $userItems[3]);

    }

    public function testFilterActivationLength() {
        $rawUserList = $this->orderElementsRepositoryProvider();
        $this->populateUserRepository($rawUserList);

        $userFilter = new UserListFilterDTO();
        $userFilter->activationLength = 2;

        $userList = $this->userRepository->find($userFilter);
        $userItems = $userList->getIterator();

        $this->assertCount(3, $userItems);
        $this->assertUser($rawUserList[3], $userItems[0]);
        $this->assertUser($rawUserList[2], $userItems[1]);
        $this->assertUser($rawUserList[1], $userItems[2]);

        $userFilter->activationLength = 3;

        $userList = $this->userRepository->find($userFilter);
        $userItems = $userList->getIterator();

        $this->assertCount(1, $userItems);
        $this->assertUser($rawUserList[3], $userItems[0]);
    }

    public function testCountryFilter() {
        $rawUserList = $this->orderElementsRepositoryProvider();
        $this->populateUserRepository($rawUserList);

        $userFilter = new UserListFilterDTO();
        $userFilter->countries = [ 'ES' ];

        $userList = $this->userRepository->find($userFilter);
        $userItems = $userList->getIterator();

        $this->assertCount(2, $userItems);
        $this->assertUser($rawUserList[2], $userItems[0]);
        $this->assertUser($rawUserList[0], $userItems[1]);

        $userFilter->countries = [ 'ES', 'CN' ];

        $userList = $this->userRepository->find($userFilter);
        $userItems = $userList->getIterator();

        $this->assertCount(3, $userItems);
        $this->assertUser($rawUserList[3], $userItems[0]);
        $this->assertUser($rawUserList[2], $userItems[1]);
        $this->assertUser($rawUserList[0], $userItems[2]);
    }


    public function testActivationLengthAndCountryFilter() {
        $rawUserList = $this->orderElementsRepositoryProvider();
        $this->populateUserRepository($rawUserList);

        $userFilter = new UserListFilterDTO();
        $userFilter->countries = [ 'ES' ];
        $userFilter->activationLength = 2;

        $userList = $this->userRepository->find($userFilter);
        $userItems = $userList->getIterator();

        $this->assertCount(1, $userItems);
        $this->assertUser($rawUserList[2], $userItems[0]);
    }

    private function assertUser(array $expectedUser, User $actualUser): void {
        $this->assertEquals($expectedUser[0], $actualUser->id());
        $this->assertEquals($expectedUser[1], $actualUser->name());
        $this->assertEquals($expectedUser[2], $actualUser->surname());
        $this->assertEquals($expectedUser[3], $actualUser->email());
        $this->assertEquals($expectedUser[4], $actualUser->country());
        $this->assertEquals($expectedUser[5], $actualUser->createAt());
        $this->assertEquals($expectedUser[6], $actualUser->activateAt());
        $this->assertEquals($expectedUser[7], $actualUser->chargerId());
    }

    private function orderElementsRepositoryProvider(): array {
        return [
            [ 0, 'B', 'B', 'b_b@email.com', 'ES', (new \DateTime('now'))->modify('-1 day'), new \DateTime('now'), 0 ],
            [ 1, 'B', 'A', 'b_a@email.com', 'EN', (new \DateTime('now'))->modify('-2 day'), new \DateTime('now'), 1 ],
            [ 2, 'A', 'B', 'a_b@email.com', 'ES', (new \DateTime('now'))->modify('-2 day'), new \DateTime('now'), 2 ],
            [ 3, 'A', 'A', 'a_a@email.com', 'CN', (new \DateTime('now'))->modify('-365 day'), new \DateTime('now'), 3 ]
        ];
    }

    private function populateUserRepository(array $rawUserList): void {
        foreach($rawUserList as $rawUser) {
            $user = new User(
                $rawUser[0],
                $rawUser[1],
                $rawUser[2],
                $rawUser[3],
                $rawUser[4],
                $rawUser[5],
                $rawUser[6],
                $rawUser[7]
            );

            $this->userRepository->addUser($user);
        }
    }

}