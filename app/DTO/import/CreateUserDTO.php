<?php

namespace App\DTO\import;

use Spatie\DataTransferObject\DataTransferObject;

class CreateUserDTO extends DataTransferObject
{
    public string $name;

    public string $email;

    public string $password;
}
