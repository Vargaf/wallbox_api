<?php

namespace Wallbox\Tests\Users;

use PHPUnit\Framework\TestCase;
use Wallbox\Domain\Users\Model\User;

class AmazonrepositoryTest extends TestCase {

    private AmazonUserRepositoryMock $userRepository;

    private User $user0;
    private User $user1;

    protected function setUp(): void {
        $this->userRepository = new AmazonUserRepositoryMock();

        $this->user0 = new User(
            0,
            'Ey',
            'Ey surname',
            'ey_email@email.com',
            'ES',
            (new \DateTime('now'))->modify('-1 day'),
            new \DateTime('now'),
            0
        );

        $this->user1 = new User(
            1,
            'Bi',
            'Bi surname',
            'Bi_email@email.com',
            'ES',
            (new \DateTime('now'))->modify('-1 day'),
            new \DateTime('now'),
            1
        );
    }

    public function testEnvironment() {
        $this->userRepository->addUser($this->user0);
        $this->userRepository->addUser($this->user1);

        $userList = $this->userRepository->findAll();
        $userItems = $userList->toArray();

        $this->assertUser($this->user1, $userItems[0]);
        $this->assertUser($this->user0, $userItems[1]);

    }

    private function assertUser(User $user, array $userArray): void {
        $this->assertEquals($user->id(), $userArray['id']);
        $this->assertEquals($user->name(), $userArray['name']);
        $this->assertEquals($user->surname(), $userArray['surname']);
        $this->assertEquals($user->email(), $userArray['email']);
        $this->assertEquals($user->country(), $userArray['country']);
        $this->assertEquals($user->createAt()->getTimestamp(), $userArray['createAt']);
        $this->assertEquals($user->activateAt()->getTimestamp(), $userArray['activateAt']);
        $this->assertEquals($user->chargerId(), $userArray['chargerId']);
    }

}