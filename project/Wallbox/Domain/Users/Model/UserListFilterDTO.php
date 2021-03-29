<?php

namespace Wallbox\Domain\Users\Model;

class UserListFilterDTO {
    
    public ?int $activationLength = null;

    public array $countries = [];

}