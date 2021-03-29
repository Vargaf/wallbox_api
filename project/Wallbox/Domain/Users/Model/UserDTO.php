<?php

namespace Wallbox\Domain\Users\Model;

class UserDTO {

    public int $id;

    public string $name;
    
    public string $surname;
    
    public string $email;

    public string $country;
    
    public int $createAt;
    
    public int $activateAt;
    
    public int $chargerId;

}